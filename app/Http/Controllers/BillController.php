<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use Stripe;

class BillController extends Controller
{
    public function showList()
    {
        $bills = Bill::all();
        
        return view('billing.list', ['bills' => $bills]);
    }

    public function loadNewBillForm()
    {
        $vendors = Vendor::all();
        
        return view('billing.new', ['vendors' => $vendors]);
    }

    public function createNewBill(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,VendorID',
            'bill_date' => 'required|date',
            'due_date' => 'date|nullable',
            'total_amount' => 'required|numeric',
            'payment_term' => 'required',
            'billing_address' => 'required',
            'item_name.*' => 'required',
            'qty.*' => 'required|integer|min:0',
            'unit_price.*' => 'required|numeric|min:0',
            'total_price.*' => 'required|numeric|min:0',
            'attachment' => 'file|mimes:pdf|max:20480',
        ]);

        // Generate a unique identifier for the bill_id
        $bill_id = Str::uuid()->toString();

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('bills', 'public');
        }

        // Create the Bill
        $bill = Bill::create([
            'vendor_id' => $request->vendor_id,
            'bill_id' => $bill_id,
            'bill_no' => $bill_id,
            'bill_date' => $request->bill_date,
            'bill_status' => 'Pending',
            'due_date' => $request->due_date,
            'total_amount' => $request->total_amount,
            'payment_term' => $request->payment_term,
            'billing_address' => $request->billing_address,
            'memo' => $request->memo,
            'attachment' => $attachmentPath,
        ]);

        // Create the BillItems
        if ($request->has('item_name')) {
            foreach ($request->item_name as $key => $item_name) {
                BillItem::create([
                    'bill_id' => $bill_id,
                    'item_name' => $item_name,
                    'description' => $request->description[$key] ?? null,
                    'qty' => $request->qty[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_price' => $request->total_price[$key],
                ]);
            }
        }
        
        return redirect()->route('billing.index')->with('success', 'Bill created successfully!');
    }

    public function showBillDetails()
    {
        
    }

    public function downloadPdf($id)
    {
        $bill = Bill::with(['vendor', 'items'])->where('bill_id', $id)->firstOrFail(); 

        $pdf = Pdf::loadView('pdf.bill_template', compact('bill'));
        
        return $pdf->download('bill_' . $bill->bill_no . '.pdf');
    }

    public function stripe($id)
    {
        $bills = Bill::with('vendor')->where('bill_id', $id)->first();

        return view('billing.stripe', ['bills' => $bills]);
    }

    public function stripePost(Request $request, $id)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $bill = Bill::where('bill_id', $id)->first();

        $accountNo = 'acct_1QnwnTAH8IPU0KMS';

        $value = $bill->total_amount;

        try {
        Stripe\Transfer::create([
            "amount" => $value * 100,
            "currency" => "sgd",
            "destination" => $accountNo,
            "description" => "From ABC Company"
        ]);

        // Update the bill status
        Bill::where('bill_id', $id)->update(['bill_status' => 'Paid']);;

        // Fetch all bills to pass to the view
        $bills = Bill::all();

        return view('billing.list', ['bills' => $bills]);

        } catch (\Exception $e) {
            return redirect()->route('billing.index')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
}
