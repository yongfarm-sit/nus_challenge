<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\CustomerInvoice;
use App\Models\InventoryItem;
use App\Models\Reimbursement;
use Barryvdh\DomPDF\Facade\Pdf;
use Session; 
use Stripe\Stripe;
use Stripe\Balance;
use Stripe\BalanceTransaction;

class FinancialReportController extends Controller
{
    public function showFinancialReport()
    {
        $balanceSheetData = $this->getBalanceSheetData();
        $profitLossData = $this->getProfitLossData();

        return view('financialreport.report', compact('balanceSheetData', 'profitLossData'));
    }

    public function showSalesReport()
    {
        $highestPayingCustomers = $this->getHighestPayingCustomers();
        $highestValueAccountsReceivable = $this->getHighestValueAccountsReceivable();
        
        return view('financialreport.salesreport', compact('highestPayingCustomers', 'highestValueAccountsReceivable'));
    }

    public function showVendorReport()
    {
        $mostPaidVendors = $this->getMostPaidVendors();
        $vendorsWithMostTransactions = $this->getVendorsWithMostTransactions();
        $vendorsWithHighestUnpaidBills = $this->getVendorsWithHighestUnpaidBills();

        return view('financialreport.vendorreport', compact('mostPaidVendors', 'vendorsWithMostTransactions', 'vendorsWithHighestUnpaidBills'));
    }

    public function showInventoryReport()
    {
        $topPurchasedItems = $this->getTopPurchasedItems(); // top 5 over the past 5 years
        $topPurchasedItemsCurrentYear = $this->getTopPurchasedItems(date('Y'));
        $highestValueItems = $this->getHighestValueItems();

        return view('financialreport.inventoryreport', compact('topPurchasedItems', 'topPurchasedItemsCurrentYear', 'highestValueItems'));
    }

    public function downloadPdf()
    {
        $startYear = date('Y', strtotime('-1 year'));
        $endYear = date('Y');
        $currentYear = date('Y');

        $balanceSheetData = $this->getBalanceSheetData();
        $profitLossData = $this->getProfitLossData();
        
        $highestValueItems = $this->getHighestValueItems();
        $topPurchasedItems = $this->getTopPurchasedItems();
        $topPurchasedItemsCurrentYear = $this->getTopPurchasedItems($currentYear);

        $highestPayingCustomers = $this->getHighestPayingCustomers();
        $highestValueAccountsReceivable = $this->getHighestValueAccountsReceivable();
    
        $mostPaidVendors = $this->getMostPaidVendors();
        $vendorsWithMostTransactions = $this->getVendorsWithMostTransactions();
        $vendorsWithHighestUnpaidBills = $this->getVendorsWithHighestUnpaidBills();
    
        $pdf = Pdf::loadView('pdf.report_template', compact(
            'balanceSheetData', 'profitLossData', 
            'topPurchasedItems', 'topPurchasedItemsCurrentYear', 'highestValueItems',
            'highestPayingCustomers', 'highestValueAccountsReceivable', 
            'mostPaidVendors', 'vendorsWithMostTransactions', 'vendorsWithHighestUnpaidBills'
        ));

        return $pdf->download('financial_report_' . $startYear . '_to_' . $endYear . '.pdf');
    }

    // Sales / Invoices
    private function getHighestPayingCustomers() {
        $highestPayingCustomers = CustomerInvoice::selectRaw('customer.ContactPerson, SUM(TotalAmount) as total_amount')
            ->join('customer', 'CustomerInvoice.CustomerID', '=', 'customer.CustomerID')
            ->groupBy('customer.ContactPerson')
            ->orderBy('total_amount', 'desc')
            ->take(5)
            ->get();

        return $highestPayingCustomers;
    }

    public function getHighestValueAccountsReceivable() {
        $highestValueAccountsReceivable = CustomerInvoice::selectRaw('customer.ContactPerson, SUM(TotalAmount) as total_amount')
            ->join('customer', 'customerinvoice.CustomerID', '=', 'customer.CustomerID')
            ->where('customerinvoice.Status', 'Pending')
            ->groupBy('customer.ContactPerson')
            ->orderBy('total_amount', 'desc')
            ->take(5)
            ->get();

        return $highestValueAccountsReceivable;
    }

    // Vendor
    private function getMostPaidVendors() {
        $mostPaidVendors = Bill::selectRaw('vendors.CompanyName, SUM(bills.total_amount) as total_paid')
            ->join('vendors', 'bills.vendor_id', '=', 'vendors.VendorID')
            ->groupBy('vendors.CompanyName')
            ->orderBy('total_paid', 'desc')
            ->take(5)
            ->get();

        return $mostPaidVendors;
    }

    private function getVendorsWithMostTransactions() {
        $vendorsWithMostTransactions = Bill::selectRaw('vendors.CompanyName, COUNT(bills.bill_id) as total_transactions')
            ->join('vendors', 'bills.vendor_id', '=', 'vendors.VendorID')
            ->groupBy('vendors.CompanyName')
            ->orderBy('total_transactions', 'desc')
            ->take(5)
            ->get();

        return $vendorsWithMostTransactions;
    }
    
    public function getVendorsWithHighestUnpaidBills() {
        $vendorsWithHighestUnpaidBills = Bill::selectRaw('vendors.CompanyName, SUM(bills.total_amount) as total_unpaid')
            ->join('vendors', 'bills.vendor_id', '=', 'vendors.VendorID')
            ->where('bills.bill_status', 'Pending')
            ->groupBy('vendors.CompanyName')
            ->orderBy('total_unpaid', 'desc')
            ->take(5)
            ->get();

        return $vendorsWithHighestUnpaidBills;
    }

    // Inventory
    private function getHighestValueItems()
    {
        $highestValueItems = InventoryItem::selectRaw('item_name, quantity_on_hand, ppu, (quantity_on_hand * ppu) as total_value')
            ->orderBy('total_value', 'desc')
            ->take(5)
            ->get();
        
        return $highestValueItems;
    }

    private function getTopPurchasedItems($year = null)
    {
        $currentYear = date('Y');
        $startYear = $currentYear - 4;

        if ($year) {
            $topPurchasedItems = Bill::selectRaw('YEAR(bill_date) as year, item_name, SUM(total_price) as total_value')
                ->join('bill_item', 'bills.bill_id', '=', 'bill_item.bill_id')
                ->whereYear('bill_date', $year)
                ->groupBy('year', 'item_name')
                ->orderBy('total_value', 'desc')
                ->take(5)
                ->get();
        } else {
            $topPurchasedItems = Bill::selectRaw('YEAR(bill_date) as year, item_name, SUM(total_price) as total_value')
                ->join('bill_item', 'bills.bill_id', '=', 'bill_item.bill_id')
                ->whereBetween('bill_date', ["$startYear-01-01", "$currentYear-12-31"])
                ->groupBy('year', 'item_name')
                ->orderBy('year')
                ->orderBy('total_value', 'desc') //items with the highest quantities come first within each year
                ->get()
                ->groupBy('year')
                ->map(function ($yearGroup) {
                    return $yearGroup->take(5);
                }
            );
        }

        return $topPurchasedItems;
    }

    // Financial Statements
    private function getBalanceSheetData()
    {
        $currentYear = date('Y');
        $previousYear = date('Y', strtotime('-1 year'));

        // Set Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Balance Sheet
        $balance = Balance::retrieve();
        $availableAmount = 0;
        $pendingAmount = 0;

        // Check if the 'available' balance is set and is an array
        if (isset($balance->available) && is_array($balance->available)) {
            foreach ($balance->available as $fund) {
                $availableAmount += $fund->amount; // Sum all available amounts
            }
        }

        // Check if the 'pending' balance is set and is an array
        if (isset($balance->pending) && is_array($balance->pending)) {
            foreach ($balance->pending as $fund) {
                $pendingAmount += $fund->amount; // Sum all pending amounts
            }
        }

        // Sum Available & Pending amounts & convert cents to dollars  
        $cashEquivalentsCurrent = ($availableAmount + $pendingAmount)/100;

        // Retrieve balance transactions between the latest balance and the balance as of 31st December of the previous year
        // $previousPeriodEnd = strtotime("$previousYear-12-31 23:59:59");
        $previousPeriodEnd = strtotime("2025-02-04 23:59:59");
        $currentPeriod = time(); //balance as of now

        $balanceTransactionsFromPreviousPeriodToCurrent = BalanceTransaction::all([
            'created' => [
                'gte' => $previousPeriodEnd,
                'lte' => $currentPeriod,
            ],
        ]);

        $accountBalance = $cashEquivalentsCurrent * 100; //convert dollars to cents
        foreach ($balanceTransactionsFromPreviousPeriodToCurrent as $transaction) {
            $accountBalance -= $transaction->amount -= $transaction->fee;
        }
        $cashEquivalentsPrevious = $accountBalance / 100;

        // Accounts Receivable
        $accountsReceivableCurrent = CustomerInvoice::whereYear('InvoiceDate', $currentYear)
            ->where('Status', 'Pending')
            ->sum('TotalAmount');

        $accountsReceivablePrevious = CustomerInvoice::whereYear('InvoiceDate', $previousYear)
            ->where('Status', 'Pending')
            ->sum('TotalAmount');

        // Inventory
        $inventoryValueCurrent = InventoryItem::all()->sum(function ($item) {
            return $item->quantity_on_hand * $item->ppu;
        });
        
        $inventoryValueAcquiredWithinYear = Bill::whereYear('bill_date', $currentYear)
            ->sum('total_amount');
        $inventoryValueSoldWithinYear = CustomerInvoice::whereYear('InvoiceDate', $currentYear)
            ->sum('TotalAmount');
        
        $inventoryValuePrevious = $inventoryValueCurrent
                                -$inventoryValueAcquiredWithinYear
                                +$inventoryValueSoldWithinYear;

        // Property, Plant & Equipment
        $propertyPlantEquipmentCurrent = 70000; // Placeholder values
        $propertyPlantEquipmentPrevious = 50000;

        // Total Assets
        $totalAssetsCurrent = $cashEquivalentsCurrent 
                            + $accountsReceivableCurrent 
                            + $inventoryValueCurrent 
                            + $propertyPlantEquipmentCurrent;

        $totalAssetsPrevious = $cashEquivalentsPrevious
                            + $accountsReceivablePrevious 
                            + $inventoryValuePrevious 
                            + $propertyPlantEquipmentPrevious;

        // Accounts Payable
        $accountsPayableCurrent = Bill::whereYear('due_date', $currentYear)
            ->where('bill_status', 'Pending')
            ->sum('total_amount');

        $accountsPayablePrevious = Bill::whereYear('due_date', $previousYear)
            ->where('bill_status', 'Pending')
            ->sum('total_amount');

        $equityCapitalCurrent = 200000;
        $equityCapitalPrevious = 200000;

        $retainedEarningsCurrent = $totalAssetsCurrent - $accountsPayableCurrent - $equityCapitalCurrent;
        $retainedEarningsPrevious = $totalAssetsPrevious - $accountsPayablePrevious - $equityCapitalPrevious;

        $totalLiabilitiesAndEquitiesCurrent = $accountsPayableCurrent + $equityCapitalCurrent + $retainedEarningsCurrent;
        $totalLiabilitiesAndEquitiesPrevious = $accountsPayablePrevious + $equityCapitalPrevious + $retainedEarningsPrevious;

        return [
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'currentAssets' => [
                'cashEquivalents' => [
                    'current' => $cashEquivalentsCurrent,
                    'previous' => $cashEquivalentsPrevious,
                    'change' => $this->calculateChange($cashEquivalentsCurrent, $cashEquivalentsPrevious)
                ],
                'accountsReceivable' => [
                    'current' => $accountsReceivableCurrent,
                    'previous' => $accountsReceivablePrevious,
                    'change' => $this->calculateChange($accountsReceivableCurrent, $accountsReceivablePrevious)
                ],
                'inventory' => [
                    'current' => $inventoryValueCurrent,
                    'previous' => $inventoryValuePrevious,
                    'change' => $this->calculateChange($inventoryValueCurrent, $inventoryValuePrevious)
                ],
            ],
            'nonCurrentAssets' => [
                'propertyPlantEquipment' => [
                    'current' => $propertyPlantEquipmentCurrent,
                    'previous' => $propertyPlantEquipmentPrevious,
                    'change' => $this->calculateChange($propertyPlantEquipmentCurrent, $propertyPlantEquipmentPrevious)
                ]
            ],
            'totalAssets' => [
                'current' => $totalAssetsCurrent,
                'previous' => $totalAssetsPrevious,
                'change' => $this->calculateChange($totalAssetsCurrent, $totalAssetsPrevious)
            ],
            'liabilitiesAndEquities' => [
                'accountsPayable' => [
                    'current' => $accountsPayableCurrent,
                    'previous' => $accountsPayablePrevious,
                    'change' => $this->calculateChange($accountsPayableCurrent, $accountsPayablePrevious)
                ],
                'equityCapital' => [
                    'current' => $equityCapitalCurrent,
                    'previous' => $equityCapitalPrevious,
                    'change' => $this->calculateChange($equityCapitalCurrent, $equityCapitalPrevious)
                ],
                'retainedEarnings' => [
                    'current' => $retainedEarningsCurrent,
                    'previous' => $retainedEarningsPrevious,
                    'change' => $this->calculateChange($retainedEarningsCurrent, $retainedEarningsPrevious)
                ]
            ],
            'totalLiabilitiesAndEquities' => [
                'current' => $totalLiabilitiesAndEquitiesCurrent,
                'previous' => $totalLiabilitiesAndEquitiesPrevious,
                'change' => $this->calculateChange($totalLiabilitiesAndEquitiesCurrent, $totalLiabilitiesAndEquitiesPrevious)
            ]
        ];
    }

    private function getProfitLossData()
    {
        $currentYear = date('Y');
        $previousYear = date('Y', strtotime('-1 year'));

        // Profit & Loss
        $salesRevenueCurrent = CustomerInvoice::whereYear('InvoiceDate', $currentYear)->sum('TotalAmount');
        $salesRevenuePrevious = CustomerInvoice::whereYear('InvoiceDate', $previousYear)->sum('TotalAmount');

        // Operating Expenses
        $salariesCurrent = 25000; // placeholder
        $salariesPrevious = 10000; // placeholder

        $reimbursementsTotalCurrent = Reimbursement::whereYear('purchase_date', $currentYear)->sum('total_amount');
        $reimbursementsTotalPrevious = Reimbursement::whereYear('purchase_date', $previousYear)->sum('total_amount');

        $operatingExpensesCurrent = $salariesCurrent + $reimbursementsTotalCurrent;
        $operatingExpensesPrevious = $salariesPrevious + $reimbursementsTotalPrevious;

        $operatingProfitCurrent = $salesRevenueCurrent - $operatingExpensesCurrent;
        $operatingProfitPrevious = $salesRevenuePrevious - $operatingExpensesPrevious;

        // EBIT
        $taxesCurrent = $operatingProfitCurrent > 0 ? $operatingProfitCurrent * 0.17 : 0;
        $taxesPrevious = $operatingProfitPrevious > 0 ? $operatingProfitPrevious * 0.17 : 0;

        $netProfitCurrent = $operatingProfitCurrent - $taxesCurrent;
        $netProfitPrevious = $operatingProfitPrevious - $taxesPrevious;

        return [
            'currentYear' => $currentYear,
            'previousYear' => $previousYear,
            'revenue' => [
                'current' => $salesRevenueCurrent,
                'previous' => $salesRevenuePrevious,
                'change' => $this->calculateChange($salesRevenueCurrent, $salesRevenuePrevious)
            ],
            'salaries' => [
                'current' => $salariesCurrent,
                'previous' => $salariesPrevious,
                'change' => $this->calculateChange($salariesCurrent, $salariesPrevious)
            ],
            'reimbursements' => [
                'current' => $reimbursementsTotalCurrent,
                'previous' => $reimbursementsTotalPrevious,
                'change' => $this->calculateChange($reimbursementsTotalCurrent, $reimbursementsTotalPrevious)
            ],
            'operatingExpenses' => [
                'current' => $operatingExpensesCurrent,
                'previous' => $operatingExpensesPrevious,
                'change' => $this->calculateChange($operatingExpensesCurrent, $operatingExpensesPrevious)
            ],
            'operatingProfit' => [
                'current' => $operatingProfitCurrent,
                'previous' => $operatingProfitPrevious,
                'change' => $this->calculateChange($operatingProfitCurrent, $operatingProfitPrevious)
            ],
            'taxes' => [
                'current' => $taxesCurrent,
                'previous' => $taxesPrevious,
                'change' => $this->calculateChange($taxesCurrent, $taxesPrevious)
            ],
            'netProfit' => [
                'current' => $netProfitCurrent,
                'previous' => $netProfitPrevious,
                'change' => $this->calculateChange($netProfitCurrent, $netProfitPrevious)
            ]
        ];
    }

    private function calculateChange($current, $previous)
    {
        if ($previous == 0) {
            return $current == 0 ? 0 : 100;
        }
        return (($current - $previous) / $previous) * 100;
    }
}
