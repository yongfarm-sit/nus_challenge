const express = require('express');
const multer = require('multer');
const csvParser = require('csv-parser');
const fs = require('fs');
const axios = require('axios');
const path = require('path');
const dotenv = require('dotenv');

// Load environment variables from .env file
dotenv.config();

const app = express();
const port = 4000;

// Set up file upload using multer
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads/');
    },
    filename: (req, file, cb) => {
        cb(null, file.originalname);
    }
});
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

    const csvFilePath = req.file.path;
    const csvData = [];

    // Parse the CSV file
    fs.createReadStream(csvFilePath)
        .pipe(csvParser())
        .on('data', (row) => {
            csvData.push(row);
        })
        .on('end', async () => {
            try {
                const summary = await sendToAzureOpenAI(csvData);
                res.json({ summary });
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

// Start the server
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
