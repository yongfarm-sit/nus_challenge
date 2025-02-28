<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Financial Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-after: always;
        }
        .container {
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                <!-- Balance Sheet Table -->
                <h2>Balance Sheet</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-right">{{ $balanceSheetData['previousYear'] }} ($)</th>
                            <th class="text-right">{{ $balanceSheetData['currentYear'] }} ($)</th>
                            <th class="text-right">YoY Increase (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Assets -->
                        <tr>
                            <td colspan="4"><strong>Assets</strong></td>
                        </tr>
                        <!-- Current Assets -->
                        <tr>
                            <td colspan="4">&emsp;<strong>Current Assets</strong></td>
                        </tr>
                        <tr>
                            <td>&emsp;&emsp;Cash &amp; cash equivalents</td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['cashEquivalents']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['cashEquivalents']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['cashEquivalents']['change'], 0) }}%
                            </td>
                        </tr>
                        <tr>
                            <td>&emsp;&emsp;Accounts Receivable</td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['accountsReceivable']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['accountsReceivable']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['accountsReceivable']['change'], 0) }}%
                            </td>
                        </tr>
                        <tr>
                            <td>&emsp;&emsp;Inventory</td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['inventory']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['inventory']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['currentAssets']['inventory']['change'], 0) }}%
                            </td>
                        </tr>
                        <!-- Non-Current Assets -->
                        <tr>
                            <td colspan="4">&emsp;<strong>Non-Current Assets</strong></td>
                        </tr>
                        <tr>
                            <td>&emsp;&emsp;Property, Plant &amp; Equipment</td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['nonCurrentAssets']['propertyPlantEquipment']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['nonCurrentAssets']['propertyPlantEquipment']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['nonCurrentAssets']['propertyPlantEquipment']['change'], 0) }}%
                            </td>
                        </tr>
                        <!-- Total Assets -->
                        <tr>
                            <td><strong>Total Assets</strong></td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['totalAssets']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['totalAssets']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['totalAssets']['change'], 0) }}%
                            </td>
                        </tr>
                        
                        <!-- Spacer -->
                        <td colspan="4" class="pb-4" style="height: 20px;"></td>

                        <!-- Liabilities -->
                        <tr>
                            <td colspan="4"><strong>Liabilities & Shareholders' Equity</strong></td>
                        </tr>
                        <!-- Current Liabilities -->
                        <tr>
                            <td colspan="4">&emsp;<strong>Current Liabilities</strong></td>
                        </tr>
                        <tr>
                            <td>&emsp;&emsp;Accounts Payable</td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['accountsPayable']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['accountsPayable']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['accountsPayable']['change'], 0) }}%
                            </td>
                        </tr>
                        <!-- Shareholders' Equity -->
                        <tr>
                            <td colspan="4">&emsp;<strong>Shareholders' Equity</strong></td>
                        </tr>
                        <tr>
                            <td>&emsp;&emsp;Equity Capital</td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['equityCapital']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['equityCapital']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['equityCapital']['change'], 0) }}%
                            </td>
                        </tr>
                        <tr>
                            <td>&emsp;&emsp;Retained Earnings</td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['retainedEarnings']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['retainedEarnings']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['liabilitiesAndEquities']['retainedEarnings']['change'], 0) }}%
                            </td>
                        </tr>
                        <!-- Total L+SE -->
                        <tr>
                            <td><strong>Total Liabilities & Shareholders' Equity</strong></td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['totalLiabilitiesAndEquities']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['totalLiabilitiesAndEquities']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($balanceSheetData['totalLiabilitiesAndEquities']['change'], 0) }}%
                            </td>
                        </tr>
                        
                        <!-- Spacer -->
                        <td colspan="4" class="pb-4" style="height: 280px;"></td>
                    </tbody>
                </table>
                
                <!-- Profit & Loss Statement -->
                <h2>Profit &amp; Loss Statement</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-right">{{ $profitLossData['previousYear'] }} ($)</th>
                            <th class="text-right">{{ $profitLossData['currentYear'] }} ($)</th>
                            <th class="text-right">YoY Increase (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Revenue</td>
                            <td class="text-right">
                                {{ number_format($profitLossData['revenue']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($profitLossData['revenue']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($profitLossData['revenue']['change'], 0) }}%
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><strong>Less: Operating Expenses</strong></td>
                        </tr>
                        <tr>
                            <td>&emsp;Salaries</td>
                            <td class="text-right">
                                {{ number_format($profitLossData['salaries']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($profitLossData['salaries']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($profitLossData['salaries']['change'], 0) }}%
                            </td>
                        </tr>
                        <tr>
                            <td>&emsp;Reimbursements</td>
                            <td class="text-right">
                                {{ number_format($profitLossData['reimbursements']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($profitLossData['reimbursements']['current'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($profitLossData['reimbursements']['change'], 0) }}%
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Operating Profit</strong></td>
                            <td class="text-right">
                                <strong>{{ number_format($profitLossData['operatingProfit']['previous'], 2) }}</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ number_format($profitLossData['operatingProfit']['current'], 2) }}</strong>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Less: Taxes (17%)</td>
                            <td class="text-right">
                                {{ number_format($profitLossData['taxes']['previous'], 2) }}
                            </td>
                            <td class="text-right">
                                {{ number_format($profitLossData['taxes']['current'], 2) }}
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Net Profit</strong></td>
                            <td class="text-right">
                                <strong>{{ number_format($profitLossData['netProfit']['previous'], 2) }}</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ number_format($profitLossData['netProfit']['current'], 2) }}</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ number_format($profitLossData['netProfit']['change'], 0) }}%</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="page-break"></div>

                <div class="container">
                    <h2>Inventory Report</h2>
                    <h3>Top 5 Purchased Items for the Current Year</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">Item Name</th>
                                <th>Total Value ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topPurchasedItemsCurrentYear as $item)
                                <tr>
                                    <td class="text-left">{{ $item->item_name }}</td>
                                    <td>{{ number_format($item->total_value, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h3>Top 5 Valued Items in Stock</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">Item Name</th>
                                <th>Total Value ($)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($highestValueItems as $item)
                                <tr>
                                    <td class="text-left">{{ $item->item_name }}</td>
                                    <td>{{ number_format($item->total_value, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            <div class="page-break"></div>

            <div class="container">
                <h2>Sales Report</h2>
                <h3>Highest Paying Customers</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left">Customer</th>
                            <th class="text-right">Total Amount ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($highestPayingCustomers as $customer)
                            <tr>
                                <td class="text-left">{{ $customer->ContactPerson }}</td>
                                <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3>Customers with Highest Amount of Unpaid Invoices</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left">Customer</th>
                            <th class="text-right">Total Amount ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($highestValueAccountsReceivable as $customer)
                            <tr>
                                <td class="text-left">{{ $customer->ContactPerson }}</td>
                                <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="page-break"></div>

            <div class="container">
                <h2>Vendor Report</h2>
                <h3>Highest Paid Vendors</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left">Vendor</th>
                            <th class="text-right">Amount ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mostPaidVendors as $vendor)
                            <tr>
                                <td class="text-left">{{ $vendor->CompanyName }}</td>
                                <td class="text-right">{{ number_format($vendor->total_paid, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3>Vendors with Most Transactions</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left">Vendor</th>
                            <th class="text-right">Transactions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendorsWithMostTransactions as $vendor)
                            <tr>
                                <td class="text-left">{{ $vendor->CompanyName }}</td>
                                <td class="text-right">{{ $vendor->total_transactions }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3>Vendors with Highest Amount of Unpaid Bills</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left">Vendor</th>
                            <th class="text-right">Amount ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendorsWithHighestUnpaidBills as $vendor)
                            <tr>
                                <td class="text-left">{{ $vendor->CompanyName }}</td>
                                <td class="text-right">{{ number_format($vendor->total_unpaid, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>