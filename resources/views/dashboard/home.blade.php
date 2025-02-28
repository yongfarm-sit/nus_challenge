@extends('layouts.master')
@section('content')
    
    <?php

        $hour   = date ("G");
        $minute = date ("i");
        $second = date ("s");
        $msg = " Today is " . date ("l, M. d, Y.");

        if ($hour == 00 && $hour <= 9 && $minute <= 59 && $second <= 59) {
            $greet = "Good Morning,";
        } else if ($hour >= 10 && $hour <= 11 && $minute <= 59 && $second <= 59) {
            $greet = "Good Day,";
        } else if ($hour >= 12 && $hour <= 15 && $minute <= 59 && $second <= 59) {
            $greet = "Good Afternoon,";
        } else if ($hour >= 16 && $hour <= 23 && $minute <= 59 && $second <= 59) {
            $greet = "Good Evening,";
        } else {
            $greet = "Welcome,";
        }
    ?>

    {{-- message --}}
    {{-- {!! Toastr::message() !!} --}}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                 <div class="row">
                    <div class="col-sm-12 mt-5">
                        @foreach($inventory_items as $item)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Warning: Low Inventory Alert </strong>– {{ $item->item_name }} stock is below the minimum threshold. Please restock soon to avoid potential delays.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <h6>{{$msg}}</h6>
                        {{-- <h3 class="page-title mt-3">{{ $greet }} {{ Auth::user()->name }}!</h3> --}}
                        <h2>Dashboard</h2>
                    </div>
                </div>
                <div class="row">
                    <!-- Content Column 1 -->
                    <div class="col-lg-4 column" id="column1">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height:400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Low Inventory Item</h6>
                                </div>
                                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                    @foreach($inventory_items as $item)
                                    <h4 class="small font-weight-bold">{{ $item->item_name }}<span class="float-right">{{ $item->quantity_on_hand }}</span></h4>
                                    <div class="progress mb-4">
                                        <!-- Calculate progress percentage based on quantity and lower limit -->
                                        @php
                                            $progress = 0;
                                            if ($item->lower_limit > 0) {
                                                $progress = min(($item->quantity_on_hand / $item->lower_limit) * 100, 100);
                                            }
                                        @endphp
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 column" id="column2">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height: 400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Outstanding Amount</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center" style="text-align: center;">
                                    <div class="row no-gutters align-items-center" style="text-align: center; width: 100%;">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold">${{ number_format($pending_bill_total, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-lg-4 column" id="column3">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height: 400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Bill Status Distribution</h6>
                                </div>
                                <div class="card-body" style="overflow: auto;">
                                    <div id="billStatusChart" style="width: 100%; height: auto; aspect-ratio: 1;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 column" id="column4">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height: 400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Receipt Trends</h6>
                                </div>
                                <div class="card-body" style="overflow: auto;">
                                    <div id="receiptTrendsChart" style="width: 100%; height: auto; aspect-ratio: 1;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-lg-4 column" id="column5">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height: 400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Profit and Loss</h6>
                                </div>
                                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                    <h3 class="font-weight-bold">$6,576</h3>
                                    <h4 class="small mb-4">Net income for last 30 days</h4>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex flex-column">
                                            <div class="font-weight-bold">Income</div>
                                            <div><h4 class="small">$6,585</h4></div>
                                        </div>
                                        <div class="progress w-75">
                                            <div class="progress-bar bg-dark" style="width: 75%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="d-flex flex-column">
                                            <div class="font-weight-bold">Expenses</div>
                                            <div><h4 class="small">$9</h4></div>
                                        </div>
                                        <div class="progress w-75">
                                            <div class="progress-bar bg-warning" style="width: 10%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-lg-4 column" id="column6">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height: 400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Income</h6>
                                </div>
                                <div class="card-body ml-4" style="display: flex; align-items: center;">
                                    <div class="progress-vertical" style="height: 300px; width: 30px; background-color: #e0e0e0; position: relative; border-radius: 5px;">
                                        <div class="progress-bar-vertical" style="width: 100%; height: 50%; position: absolute; bottom: 0; border-radius: 0 0 5px 5px; background-color: #1cc88a;"></div>
                                        <div class="progress-bar-vertical" style="width: 100%; height: 10%; position: absolute; bottom: 50%; border-radius: 0; background-color: #f6c23e;"></div>
                                        <div class="progress-bar-vertical" style="width: 100%; height: 40%; position: absolute; bottom: 60%; border-radius: 5px 5px 0 0 ; background-color: #858796;"></div>
                                    </div>

                                    <div style="margin-left: 50px;">
                                        <ul style="list-style-type: none; padding: 0;">
                                            <li class="mb-4"><span style="display: inline-block; width: 15px; height: 15px; background-color: #858796;"></span> $16,675</li>
                                            <li class="mb-4"><span style="display: inline-block; width: 15px; height: 15px; background-color: #f6c23e;"></span> $1,500</li>
                                            <li class="mb-4"><span style="display: inline-block; width: 15px; height: 15px; background-color: #1cc88a;"></span> $31,020</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-lg-4 column" id="column7">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height: 400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Top 5 Account Payable</h6>
                                </div>
                                <div class="card-body" style="overflow: auto;">
                                    <h3 class="font-weight-bold">${{ number_format($totalTopFiveUnpaidVendors, 0, '.', ',') }}</h3>
                                    <h4 class="small">Total AP for Top 5 Accounts</h4>
                                    <div id="vendorsWithHighestUnpaidBillsChart" style="width: 100%; height: auto; aspect-ratio: 1;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 column" id="column8">
                        <div class="box"> 
                            <div class="card shadow mb-4" style="height: 400px;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold" style="color:#009688;">Top 5 Account Receivable</h6>
                                </div>
                                <div class="card-body" style="overflow: auto;">
                                    <h3 class="font-weight-bold">${{ number_format($totalTopFiveAccountsReceivable, 0, '.', ',') }}</h3>
                                    <h4 class="small">Total AR from Top 5 Accounts</h4>
                                    <div id="highestValueAccountsReceivableChart" style="width: 100%; height: auto; aspect-ratio: 1;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    #billStatusChart, #expensesDonutChart, #arDonutChart, #payrollDonutChart {
        width: 100%;
        height: auto;
        max-height: 230px;
    }
</style>
@endpush

@push('scripts')
    <!-- Load the Google Charts Library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script type="text/javascript">
        // Load the Google Charts library
        google.charts.load('current', {
            packages: ['corechart', 'piechart']
        });

        google.charts.setOnLoadCallback(drawChart);

        // Function to draw the chart
        function drawChart() {
            var billStatusData = @json($bill_status_data);

            // Bill Status Pie Chart
            var pendingCount = parseInt(billStatusData.pending, 10);
            var paidCount = parseInt(billStatusData.paid, 10);
            var overdueCount = parseInt(billStatusData.overdue, 10);

            // Bill Status Pie Chart
            var billStatusPieData = google.visualization.arrayToDataTable([
                ['Status', 'Count'],
                ['Pending', pendingCount],
                ['Paid', paidCount],
                ['Overdue', overdueCount]
            ]);

            // Set up options for the chart
            var billStatusPieOptions = {
                is3D: true,
                pieSliceText: 'percentage',
                pieHole: 0.0,
                pieSliceTextStyle: { fontSize: 14 },
                legend: { textStyle: { fontSize: 5 } },
                slices: {
                    0: {offset: 0.1},
                    1: {offset: 0.1},
                    2: {offset: 0.1}
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('billStatusChart'));
            chart.draw(billStatusPieData, billStatusPieOptions);


            // Receipt Trends Bar Chart
            var receiptTrendsData = @json($formatted_receipt_trends_data);

            var receiptTrendsBarData = google.visualization.arrayToDataTable([
                ['Month', 'Receipts Count'],
                ...receiptTrendsData
            ]);

            var receiptTrendsBarOptions = {
                chartArea: { width: '30%' },
                hAxis: {
                    title: 'Number of Receipts',
                    minValue: 0
                },
                vAxis: {
                    title: 'Month'
                },
                legend: { position: 'none' }
            };

            var barChart = new google.visualization.BarChart(document.getElementById('receiptTrendsChart'));
            barChart.draw(receiptTrendsBarData, receiptTrendsBarOptions);


            //Accounts Receivable Chart
            var dataHighestValueAccountsReceivable = google.visualization.arrayToDataTable([
                ['Customer', 'Total Amount'],
                @foreach($highestValueAccountsReceivable as $customer)
                    ['{{ $customer->ContactPerson }}', {{ $customer->total_amount }}],
                @endforeach
            ]);

            var arDonutOptions = {
                title: 'Customers with Highest Amount of Unpaid Invoices',
                pieHole: 0.4,
                legend: { position: 'bottom' },
                pieSliceTextStyle: { fontSize: 14 },
                textStyle: { fontSize: 24 }
            };

            var highestValueAccountsReceivableChart = new google.visualization.PieChart(document.getElementById('highestValueAccountsReceivableChart'));
            highestValueAccountsReceivableChart.draw(dataHighestValueAccountsReceivable, arDonutOptions);

            //Unpaid Vendors
            var dataUnpaidVendors = google.visualization.arrayToDataTable([
                ['Vendor', 'Unpaid'],
                @foreach($vendorsWithHighestUnpaidBills as $vendor)
                    ['{{ $vendor->CompanyName }}', {{ $vendor->total_unpaid }}],
                @endforeach
            ]);

            var optionsUnpaidVendors = {
                title: 'Vendors with Highest Amount of Unpaid Bills',
                pieHole: 0.4,
                legend: { position: 'bottom' },
                textStyle: { fontSize: 24 }
            };

            var vendorsWithHighestUnpaidBillsChart = new google.visualization.PieChart(document.getElementById('vendorsWithHighestUnpaidBillsChart'));
            vendorsWithHighestUnpaidBillsChart.draw(dataUnpaidVendors, optionsUnpaidVendors);
        }
    </script>
    <script>
    $(function() {
         // Inject CSS styles dynamically using JavaScript
         const styles = `
            /* Visual cue when hovering over a droppable column (changed to grey) */
            .ui-state-highlight {
                border: 2px solid #f0f0f0; /* Grey border */
                border-radius: 25px;
                background-color: #f0f0f0; /* Light grey background */
            }
        `;

        // Append the styles to the head of the document
        const styleSheet = document.createElement("style");
        styleSheet.type = "text/css";
        styleSheet.innerText = styles;
        document.head.appendChild(styleSheet);

        // Make the columns draggable
        $(".column").draggable({
            cursor: "move",
            opacity: 0.7,
            containment: "document",
            revert: true // Ensures that the column returns to its original position if dropped in an invalid area
        });

        // Make the columns droppable and swap places when dropped
        $(".column").droppable({
            accept: ".column",
            hoverClass: "ui-state-highlight",
            drop: function(event, ui) {
                var draggedColumn = ui.helper[0]; // The column being dragged
                var targetColumn = this; // The target column where the drag ends

                // Find the target column's index in the row
                var draggedColumnIndex = $(draggedColumn).index();
                var targetColumnIndex = $(targetColumn).index();

                // If the columns are not the same, swap them
                if (draggedColumnIndex !== targetColumnIndex) {
                    // Get the parent row of the columns
                    var parentRow = $(targetColumn).parent();

                    // Swap the columns by reordering them in the DOM
                    if (draggedColumnIndex < targetColumnIndex) {
                        $(targetColumn).after($(draggedColumn)); // Move the dragged column after the target column
                    } else {
                        $(targetColumn).before($(draggedColumn)); // Move the dragged column before the target column
                    }

                    google.charts.setOnLoadCallback(drawChart);
                }
            }
        });
    });
</script>
@endpush