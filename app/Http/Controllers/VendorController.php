<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Stripe;

class VendorController extends Controller
{
    public function showVendor()
    {
        $vendor_list = Vendor::all();

        return view('vendors.vendorlist', ['vendor_list' => $vendor_list]);
    }

    public function store(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        // Validate the incoming data
        $request->validate([
            'CompanyName' => 'required|string|max:100',
            'DisplayName' => 'nullable|string|max:100',
            'ContactEmail' => 'nullable|email|max:100',
            'MobileNumber' => 'nullable|string|max:20',
            'FaxNumber' => 'nullable|string|max:20',
            'Address' => 'nullable|string|max:255',
        ]);

        // Create a new Vendor Stripe Account
        $account = $stripe->accounts->create([
            'type' => 'standard',
            'country' => 'sg'
        ]);

        // Create a new Vendor record
        $vendor = Vendor::create([
            'CompanyName' => $request->input('CompanyName'),
            'DisplayName' => $request->input('DisplayName'),
            'ContactEmail' => $request->input('ContactEmail'),
            'MobileNumber' => $request->input('MobileNumber'),
            'FaxNumber' => $request->input('FaxNumber'),
            'Address' => $request->input('Address'),
            'account_no' => $account->id,
        ]);

        // Redirect or respond with success message
        return redirect()->route('vendor.index')->with('success', 'Vendor added successfully.');
    }

    public function update(Request $request)
    {
    // Validate the request data
    $validatedData = $request->validate([
        'VendorID' => 'required|exists:vendors,VendorID',
        'CompanyName' => 'required|string|max:100',
        'DisplayName' => 'nullable|string|max:100',
        'ContactEmail' => 'nullable|email|max:100',
        'MobileNumber' => 'nullable|string|max:20',
        'FaxNumber' => 'nullable|string|max:20',
        'Address' => 'nullable|string|max:255',
    ]);

    // Find the vendor by VendorID
    $vendor = Vendor::findOrFail($validatedData['VendorID']);

    // Update vendor's data
    $vendor->update($validatedData);

    // Redirect back to the vendor list
    return redirect()->route('vendor.index')->with('success', 'Vendor updated successfully!');
}
}
