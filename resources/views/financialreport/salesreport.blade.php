@extends('layouts.master')
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Financial Report / Sales</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h2>Sales Report</h2>
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th class="text-right">($)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><strong>Highest Paying Customers</strong></td>
                </tr>
                @foreach($highestPayingCustomers as $customer)
                    <tr>
                        <td>{{ $customer->ContactPerson }}</td>
                        <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="2"><strong>Customers with Highest Amount of Unpaid Invoices</strong></td>
                </tr>
                @foreach($highestValueAccountsReceivable as $customer)
                    <tr>
                        <td>{{ $customer->ContactPerson }}</td>
                        <td class="text-right">{{ number_format($customer->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <div id="highestPayingCustomersChart" style="width: 100%; height: 500px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="highestValueAccountsReceivableChart" style="width: 100%; height: 500px;"></div>
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
        drawHighestPayingCustomersChart();
        drawHighestValueAccountsReceivableChart();
    }
    
    function drawHighestPayingCustomersChart() {
        var data = google.visualization.arrayToDataTable([
            ['Customer', 'Total Amount'],
            @foreach($highestPayingCustomers as $customer)
                ['{{ $customer->ContactPerson }}', {{ $customer->total_amount }}],
            @endforeach
        ]);

        var options = {
            title: 'Highest Paying Customers',
            pieHole: 0.4,
            legend: { position: 'bottom' },
            pieSliceTextStyle: { fontSize: 14 },
        };

        var chart = new google.visualization.PieChart(document.getElementById('highestPayingCustomersChart'));
        chart.draw(data, options);
    }

    function drawHighestValueAccountsReceivableChart() {
        var data = google.visualization.arrayToDataTable([
            ['Customer', 'Total Amount'],
            @foreach($highestValueAccountsReceivable as $customer)
                ['{{ $customer->ContactPerson }}', {{ $customer->total_amount }}],
            @endforeach
        ]);

        var options = {
            title: 'Customers with Highest Amount of Unpaid Invoices',
            pieHole: 0.4,
            legend: { position: 'bottom' },
            pieSliceTextStyle: { fontSize: 14 },
        };

        var chart = new google.visualization.PieChart(document.getElementById('highestValueAccountsReceivableChart'));
        chart.draw(data, options);
    }
</script>
@endpush
