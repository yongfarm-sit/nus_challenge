@extends('layouts.master')
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Financial Report / Vendor</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h2>Vendor Report</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-right">($)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"><strong>Highest Paid Vendors</strong></td>
                    </tr>
                    @foreach($mostPaidVendors as $vendor)
                        <tr>
                            <td>{{ $vendor->CompanyName }}</td>
                            <td class="text-right">{{ number_format($vendor->total_paid, 2) }}</td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <td colspan="4"><strong>Vendor with Highest Frequency of Transactions</strong></td>
                    </tr>
                    @foreach($vendorsWithMostTransactions as $vendor)
                        <tr>
                            <td>{{ $vendor->CompanyName }}</td>
                            <td class="text-right">{{ $vendor->total_transactions }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4"><strong>Vendor with Highest Amount of Unpaid Bills</strong></td>
                    </tr>
                    @foreach($vendorsWithHighestUnpaidBills as $vendor)
                        <tr>
                            <td>{{ $vendor->CompanyName }}</td>
                            <td class="text-right">{{ number_format($vendor->total_unpaid, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-4">
                    <div id="mostPaidVendorsChart" style="width: 100%; height: 400px;"></div>
                </div>
                <div class="col-md-4">
                    <div id="vendorsWithMostTransactionsChart" style="width: 100%; height: 400px;"></div>
                </div>
                <div class="col-md-4">
                    <div id="vendorsWithHighestUnpaidBillsChart" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        drawMostPaidVendorsChart();
        drawVendorsWithMostTransactionsChart();
        drawVendorsWithHighestUnpaidBillsChart();
    }

    function drawMostPaidVendorsChart() {
        var data = google.visualization.arrayToDataTable([
            ['Vendor', 'Paid'],
            @foreach($mostPaidVendors as $vendor)
                ['{{ $vendor->CompanyName }}', {{ $vendor->total_paid }}],
            @endforeach
        ]);

        var options = {
            title: 'Highest Paid Vendors',
            pieHole: 0.4,
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('mostPaidVendorsChart'));
        chart.draw(data, options);
    }

    function drawVendorsWithMostTransactionsChart() {
        var data = google.visualization.arrayToDataTable([
            ['Vendor', 'Transactions'],
            @foreach($vendorsWithMostTransactions as $vendor)
                ['{{ $vendor->CompanyName }}', {{ $vendor->total_transactions }}],
            @endforeach
        ]);

        var options = {
            title: 'Vendors with Most Transactions',
            pieHole: 0.4,
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('vendorsWithMostTransactionsChart'));
        chart.draw(data, options);
    }

    function drawVendorsWithHighestUnpaidBillsChart() {
        var data = google.visualization.arrayToDataTable([
            ['Vendor', 'Unpaid'],
            @foreach($vendorsWithHighestUnpaidBills as $vendor)
                ['{{ $vendor->CompanyName }}', {{ $vendor->total_unpaid }}],
            @endforeach
        ]);

        var options = {
            title: 'Vendors with Highest Amount of Unpaid Bills',
            pieHole: 0.4,
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('vendorsWithHighestUnpaidBillsChart'));
        chart.draw(data, options);
    }
</script>
@endpush
