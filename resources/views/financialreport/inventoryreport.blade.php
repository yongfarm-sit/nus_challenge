@extends('layouts.master')
@section('content')
<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12 mt-5">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Financial Report / Inventory</li>
                        </ul>
                    </div>
                </div>
            </div>

            <h2>Inventory Report</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-right">($)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4"><strong>Top 5 Valued Items in Stock</strong></td>
                    </tr>
                    @foreach($highestValueItems as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td class="text-right">{{ number_format($item->total_value, 2) }}</td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <td colspan="4"><strong>Top 5 Purchased Items for the Year</strong></td>
                    </tr>
                    @foreach($topPurchasedItemsCurrentYear as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td class="text-right">{{ number_format($item->total_value, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <div id="highestValueItemsChart" style="width: 100%; height: 500px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="topPurchasedItemsChart" style="width: 100%; height: 500px;"></div>
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
        drawHighestValueItemsChart();
        drawTopPurchasedItemsChart();
    }

    function drawHighestValueItemsChart() {
        var data = google.visualization.arrayToDataTable([
            ['Item Name', 'Total Value'],
            @foreach($highestValueItems as $item)
                ['{{ $item->item_name }}', {{ $item->total_value }}],
            @endforeach
        ]);

        var options = {
            width: 400,
            height: 400,
            pieHole: 0.4,
            title: 'Top 5 Valued Items in Stock',
            legend: { position: 'top', maxLines: 3 },
            pieSliceTextStyle: { fontSize: 14 }
        };

        var chart = new google.visualization.PieChart(document.getElementById('highestValueItemsChart'));
        chart.draw(data, options);
    }

    function drawTopPurchasedItemsChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', @foreach($topPurchasedItems->first() as $item) '{{ $item->item_name }}', @endforeach { role: 'annotation' }],
            @foreach($topPurchasedItems as $year => $items)
                ['{{ $year }}', @foreach($items as $item) {{ $item->total_value }}, @endforeach ''],
            @endforeach
        ]);

        var options = {
            isStacked: true,
            width: 400,
            height: 400,
            title: 'Top 5 Purchased Items for the Past 5 Years',
            hAxis: {
                title: 'Year',
            },
            vAxis: {
                title: 'Total Value ($)',
                minValue: 0
            },
            legend: { position: 'top', maxLines: 3 },
            bar: { groupWidth: '75%' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('topPurchasedItemsChart'));
        chart.draw(data, options);
    }
</script>
@endpush
