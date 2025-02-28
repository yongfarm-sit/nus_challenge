<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use App\Models\Customer;
use App\Models\CustomerInvoice;
use App\Mail\InvoiceEmail;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function showCust()
    {
        $cust_list = Customer::all();

        return view('customer.customerlist', ['cust_list' => $cust_list]);
    }

    public function addCust(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'CompanyName' => 'nullable|string|max:100',
            'ContactPerson' => 'required|string|max:100',
            'CustomerType' => 'required|string',
            'Email' => 'required|email|unique:customer',
            'ContactNo' => 'nullable|string|max:20',
            'Address' => 'nullable|string',
            'PostalCode' => 'nullable|string|max:20',
        ]);

        // Create new customer
        $customer = new Customer();
        $customer->CompanyName = $validatedData['CompanyName'];
        $customer->ContactPerson = $validatedData['ContactPerson'];
        $customer->CustomerType = $validatedData['CustomerType'];
        $customer->Email = $validatedData['Email'];
        $customer->ContactNo = $validatedData['ContactNo'];
        $customer->Address = $validatedData['Address'];
        $customer->PostalCode = $validatedData['PostalCode'];
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'Customer added successfully!');
    }

    public function updateCust(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'CustomerID' => 'required|exists:customer,CustomerID',
            'CompanyName' => 'nullable|string|max:100',
            'ContactPerson' => 'required|string|max:100',
            'CustomerType' => 'required|string',
            'Email' => 'required|email|unique:customer,Email,' . $request->CustomerID . ',CustomerID',
            'ContactNo' => 'nullable|string|max:20',
            'Address' => 'nullable|string',
            'PostalCode' => 'nullable|string|max:20',
        ]);

            // Find the customer by customerid
        $customer = Customer::findOrFail($validatedData['CustomerID']);
        $customer->update($validatedData);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully!');
    }

    public function deleteCust($customer_id)
    {
        $customer = Customer::where('CustomerID', $customer_id)->firstOrFail();
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully!');
    }

    public function custInvoice()
    {
        $cust_invoice_list = CustomerInvoice::all();
        $customers = Customer::all();

        return view('customer.customerInvoice', [
            'cust_invoice_list' => $cust_invoice_list,
            'customers' => $customers
        ]);
    }

    public function addCustInvoice(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'CustomerID' => 'required|exists:customer,CustomerID', // Ensure the customer exists
        'InvoiceDate' => 'required|date',
        'TotalAmount' => 'required|numeric|min:0',
        'Status' => 'nullable|string|max:64',
    ]);

    // Create new invoice
    $invoice = new CustomerInvoice();
    $invoice->CustomerID = $validatedData['CustomerID'];
    $invoice->InvoiceDate = $validatedData['InvoiceDate'];
    $invoice->TotalAmount = $validatedData['TotalAmount'];
    $invoice->Status = $validatedData['Status'] ?? 'Pending'; // Default to 'Pending' if no status is provided
    $invoice->save();

    return redirect()->route('customer.invoice')->with('success', 'Invoice added successfully!');
}

public function sendInvoiceEmail(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'customerID' => 'required|exists:customer,CustomerID', // Ensure customer exists
            'invoiceID' => 'required|exists:customerinvoice,InvoiceID', // Ensure invoice exists
        ]);

        // Retrieve the invoice
        $invoice = CustomerInvoice::with('customer:CustomerID,email')
        ->where('InvoiceID', $validatedData['invoiceID'])
        ->where('CustomerID', $validatedData['customerID'])
        ->firstOrFail();


        // Send the email using the Mailable class
        Mail::to($invoice->customer->email)->send(new InvoiceEmail($invoice));

        // Redirect back with a success message
        return back()->with('success', 'Invoice email sent successfully!');
    }
}
