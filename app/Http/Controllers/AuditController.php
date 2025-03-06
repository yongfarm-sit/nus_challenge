<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // To use the HTTP client to interact with the OpenAI API
use League\Csv\Reader; // To read CSV files easily

class AuditController extends Controller
{
    // Show the home page or basic view
    public function index()
    {
        return view('audit.audit'); // Blade view where the form is located
    }

    // Handle CSV upload
    public function uploadCSV(Request $request)
{
    // Validate the CSV file
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt|max:2048',
    ]);
    
    // Store the file temporarily
    $file = $request->file('csv_file');
    $path = $file->storeAs('csv_uploads', 'uploaded.csv');
    
    // Parse the CSV file
    $csv = Reader::createFromPath(storage_path('app/' . $path), 'r');
    $csv->setHeaderOffset(0); // Use first row as header
    
    // Convert the CSV data to an array
    $data = iterator_to_array($csv->getRecords());
    
    // Prepare the data to send to Gemini API
    $csvContent = json_encode($data);
    
    // Send the CSV data to Gemini API
    $response = $this->sendToLLM($csvContent);
    
    // Check if the response contains 'candidates' and extract the summary
    if ($response) {
        $summary = $response; // Since $response is directly the summary content
    } else {
        // Handle the case where the response is empty or there was an issue
        $summary = "Sorry, there was an issue generating the summary. Please try again.";
    }
    
    return view('audit.result', compact('summary'));
}


private function sendToLLM($csvContent)
{
    $apiKey = env('YOUR_GOOGLE_API_KEY'); // Make sure to store your Google API key in the .env file

    // Define the URL for the Gemini API request
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;

    // Define the data to send, including CSV content
    $data = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => "Please analyze and summarize the following CSV data: " . $csvContent
                    ]
                ]
            ]
        ]
    ];

    // Make the POST request using Laravel's HTTP client
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post($url, $data);

    // Check if the response failed
    if ($response->failed()) {
        \Log::error('Google Gemini API Request Failed:', [
            'status' => $response->status(),
            'response_body' => $response->body(),
        ]);
        return null; // Handle failure appropriately
    }

    // Get the response body as JSON
    $responseJson = $response->json();

    // Log the response to inspect its structure
    \Log::info('Google Gemini API Response:', $responseJson);

    // Extract the summary from the 'candidates' field
    if (isset($responseJson['candidates'][0]['content']['parts'][0]['text'])) {
        return $responseJson['candidates'][0]['content']['parts'][0]['text']; // Return the generated summary content
    } else {
        \Log::error('Google Gemini API Response Error:', $responseJson);
        return null; // Return null if no valid response found
    }
}


    
    
    
}

