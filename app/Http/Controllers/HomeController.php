<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FinancialReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Booking;
use App\Models\InventoryItem;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // home page
    public function index()
    {

        // Fetch inventory items where quantity_on_hand is less than lower_limit
        $inventory_items = InventoryItem::whereRaw('quantity_on_hand < lower_limit')
        ->get(['item_name', 'quantity_on_hand', 'lower_limit']);

        // Fetch the sum of total_amount from the bills table where bill_status is 'pending'
        $pending_bill_total = \DB::table('bills')
        ->where('bill_status', 'pending')
        ->sum('total_amount');

        // Count the number of bills by status and store in an array
        $bill_status_counts = \DB::table('bills')
        ->selectRaw("
            SUM(CASE WHEN bill_status = 'pending' THEN 1 ELSE 0 END) AS pending,
            SUM(CASE WHEN bill_status = 'paid' THEN 1 ELSE 0 END) AS paid,
            SUM(CASE WHEN bill_status = 'overdue' THEN 1 ELSE 0 END) AS overdue
        ")
        ->first();

        $bill_status_data = [
            'pending' => $bill_status_counts->pending,
            'paid' => $bill_status_counts->paid,
            'overdue' => $bill_status_counts->overdue
        ];

        // Get the current date and the date 6 months ago
        $start = Carbon::now()->subMonths(6)->startOfMonth();
        $end = Carbon::now()->startOfMonth();

        // Generate a list of months in the range with default counts of 0
        $allMonths = [];
        while ($start <= $end) {
            $allMonths[$start->format('Y-m')] = 0;
            $start->addMonth();
        }

        // Query to get actual receipt counts grouped by month
        $receipt_trends_data = \DB::table('receipts')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        // Merge the query result with the allMonths array
        foreach ($allMonths as $month => $count) {
            $allMonths[$month] = $receipt_trends_data[$month]->count ?? 0;
        }

        // Format the data for the chart
        $formatted_receipt_trends_data = collect($allMonths)->map(function ($count, $month) {
            return [$month, $count];
        })->values()->toArray();

        // Finances chart data
        $financialReportController = new FinancialReportController();
        $highestValueAccountsReceivable = $financialReportController->getHighestValueAccountsReceivable();
        $totalTopFiveAccountsReceivable = $highestValueAccountsReceivable->sum('total_amount');

        $vendorsWithHighestUnpaidBills = $financialReportController->getVendorsWithHighestUnpaidBills();
        $totalTopFiveUnpaidVendors = $vendorsWithHighestUnpaidBills->sum('total_unpaid');

        return view('dashboard.home', compact(
            'inventory_items', 
            'pending_bill_total', 
            'bill_status_data', 
            'formatted_receipt_trends_data',
            'highestValueAccountsReceivable',
            'vendorsWithHighestUnpaidBills',
            'totalTopFiveAccountsReceivable',
            'totalTopFiveUnpaidVendors'
        ));

    }

    // profile
    public function profile()
    {
        return view('profile');
    }
}
