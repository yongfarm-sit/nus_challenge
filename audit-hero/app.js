const express = require('express');
const multer = require('multer');
const csvParser = require('csv-parser');
const axios = require('axios');
const path = require('path');
const dotenv = require('dotenv');
const { marked } = require('marked');

// Load environment variables from .env file
dotenv.config();

const app = express();
const port = 4000;

// Set up file upload using multer (in memory)
const storage = multer.memoryStorage(); // Store files in memory
const upload = multer({ storage: storage });

// Middleware for parsing JSON
app.use(express.json());

// Serve the HTML file on GET request
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'upload_csv.html'));
});

// Route to upload the CSV
app.post('/upload-csv', upload.single('csv_file'), (req, res) => {
    if (!req.file) {
        return res.status(400).send('No file uploaded.');
    }

    const csvData = [];
    const buffer = req.file.buffer;

    // Parse the CSV file from the buffer
    require('streamifier').createReadStream(buffer)
        .pipe(csvParser())
        .on('data', (row) => {
            csvData.push(row);
        })
        .on('end', async () => {
            try {
                const summary = await sendToAzureOpenAI(csvData);

                // Pass summary data to the result page
                res.redirect(`/result?summary=${encodeURIComponent(summary)}`);
            } catch (error) {
                res.status(500).send('Error generating summary: ' + error.message);
            }
        });
});

const openAIAPIKey = process.env.AZURE_OPENAI_API_KEY;
const deploymentId = process.env.DEPLOYMENT_NAME;
const apiEndpoint = process.env.ENDPOINT_URL;

const url = `${apiEndpoint}openai/deployments/${deploymentId}/chat/completions?api-version=2024-02-01`;

// Function to send CSV data to Azure OpenAI API
async function sendToAzureOpenAI(csvData) {
    console.log('API Key:', openAIAPIKey ? 'Loaded' : 'Not Loaded');
    console.log('API Endpoint:', apiEndpoint);
    console.log('Deployment ID:', deploymentId);

    const messages = [
        {
            role: 'system',
            content: 'You are an auditor. Analyze and summarize the following CSV data. Format the output in Markdown.'
        },
        {
            role: 'user',
            content: `CSV Data:\n${JSON.stringify(csvData)}`
        }
    ];

    try {
        const response = await axios.post(url, {
            model: deploymentId,
            messages: messages,
            max_tokens: 1000,
            temperature: 0.5
        }, {
            headers: {
                'api-key': openAIAPIKey,
                'Content-Type': 'application/json'
            }
        });

        return response.data.choices[0].message.content;
    } catch (error) {
        console.error('Error:', error.response ? error.response.data : error.message);
        throw new Error('Error generating summary: ' + error.message);
    }
}

app.get('/result', (req, res) => {
    const summary = req.query.summary || 'No summary available.';
    
    // Ensure summary is properly encoded and passed
    if (!summary) {
        return res.status(400).send('Invalid summary received.');
    }
    
    // Convert the Markdown summary to HTML using 'marked'
    const htmlContent = marked(summary);

    // Render the result page
    res.send(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Audit Hero - Results</title>
        </head>
        <body>
            <h1>Audit Summary</h1>
            <div>
                <h3>Summary:</h3>
                <div>${htmlContent}</div>
            </div>
            <a href="/">Upload another CSV</a>
        </body>
        </html>
    `);
});

// Start the server
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
