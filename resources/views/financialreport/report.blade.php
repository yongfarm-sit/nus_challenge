@extends('layouts.master')
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Financial Report</li>
                        </ul>
                    </div>
                    <div class="col-sm-6 text-right">
                        <form action="{{ route('financialreport.downloadpdf') }}" method="GET" class="form-inline">
                            <!-- <div class="form-group">
                                <label for="startYear" class="mr-2">Start Year:</label>
                                <input type="number" name="startYear" id="startYear" class="form-control mr-2" style="width: 150px;" required>
                            </div>
                            <div class="form-group">
                                <label for="endYear" class="mr-2">End Year:</label>
                                <input type="number" name="endYear" id="endYear" class="form-control mr-2" style="width: 150px; margin-left: 5px;" required>
                            </div> -->
                            <button type="submit" class="btn btn-primary">Download Reports</button>
                        </form>
                    </div>
                </div>
            </div>

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
                    <td colspan="4" class="pb-4"></td>

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
                </tbody>
            </table>

            <hr>

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
                    <tr>
                        <td colspan="4" class="pb-4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
