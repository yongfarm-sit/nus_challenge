<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Reimbursement;

class ReimbursementController extends Controller
{
    public function showReimbursement()
    {
        return view('reimbursement.reimbursement', [
            'user' => Auth::user(),
        ]);
    }

    public function list()
    {
        $reimbursements = Reimbursement::latest()->get();
        return view('reimbursement.list', [
            'reimbursements' => $reimbursements,
        ]);
    }

    public function processOCR(Request $request)
    {
        \Log::info('OCR Process started');
        \Log::info('Request contents:', $request->all()); // Add this to see what's being received
        
        if (!$request->hasFile('receipt_img')) {
            \Log::info('No file found in request. Request contents:', $request->all());
            return response()->json([
                'success' => false, 
                'message' => 'Debug: No file in request'
            ], 400);
        }

        try {
            $file = $request->file('receipt_img');
            $apiUrl = "https://ocr.asprise.com/api/v1/receipt";
            $apiKey = config('services.asprise.key');

            // Log file information
            \Log::info('File details:', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);

            // Debug: Check API key
            if (empty($apiKey)) {
                \Log::error('API key not found in configuration');
                return response()->json([
                    'success' => false,
                    'message' => 'Debug: API key not found'
                ], 400);
            }

            // Modified API request
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->attach(
                'file', 
                file_get_contents($file->getRealPath()), 
                $file->getClientOriginalName()
            )->post($apiUrl, [
                'api_key' => $apiKey,
                'recognizer' => 'auto',
                'ref_no' => (string)time()
            ]);

            \Log::info('API Response Status: ' . $response->status());
            \Log::info('API Response Body: ' . $response->body());

            if (!$response->successful()) {
                \Log::error('API request failed:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'API request failed: ' . $response->status()
                ], 500);
            }

            $responseData = $response->json();
            if (empty($responseData['receipts'][0])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No receipt data found in API response'
                ], 500);
            }

            $receipt = $responseData['receipts'][0];
            return response()->json([
                'success' => true,
                'merchant_name' => $receipt['merchant_name'] ?? 'Unknown',
                'transaction_date' => $receipt['date'] ?? date('Y-m-d'),
                'total_amount' => $receipt['total'] ?? '0.00',
                'currency' => $receipt['currency'] ?? 'SGD',
                'payment_method' => $receipt['payment_method'] ?? 'Cash'
            ]);

        } catch (\Exception $e) {
            \Log::error('OCR Processing Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Debug error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|gt:0',
            'currency' => 'required|string|max:10',
            'payment_method' => 'required|string|max:50',
            'category' => 'required|string|max:100',
            'receipt_img' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        //saving in storage directory (storage/app/public/receipts)
        // if ($request->hasFile('receipt_img')) {
        //     $file = $request->file('receipt_img');
        //     $fileName = time() . '_' . $file->getClientOriginalName();
        //     $filePath = $file->storeAs('receipts', $fileName, 'public');
        //}

        try {
            if ($request->hasFile('receipt_img')) {
                $file = $request->file('receipt_img');
                $receipt_img_data = base64_encode(file_get_contents($file->getRealPath()));
            } else {
                throw new \Exception('No receipt image provided');
            }
    
            Reimbursement::create([
                'vendor_name' => $request->vendor_name,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $request->total_amount,
                'currency' => $request->currency,
                'payment_method' => $request->payment_method,
                'category' => $request->category,
                'receipt_img' => $receipt_img_data,
                'uploaded_by' => 'user',
            ]);

            return redirect()->route('reimbursement.list')->with('success', 'Reimbursement submitted successfully.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}