@extends('layouts.back')
@section('title', 'Dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('engineer.dashboard') }}">Dashboard</a></div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h4>{{ Auth::user()->name }} Dashboard</h4>                     
                    </div> -->
                    <div class="card-body mt-2 mb-3">
                        <div class="mb-3-row">
                            <div class="container">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                                    <div class="col">
                                        <div class="p-3 border bg-light" style="border-radius: 10px; font-size:larger; color:black; "><strong>My Tickets</strong>
                                            <div><strong>{{ $totalTickets }}</strong></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-3 border bg-light" style="border-radius: 10px; font-size:larger; color:brown;"><strong>Open Tickets</strong>
                                            <div><strong>{{ $openTickets }}</strong></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-3 border bg-light" style="border-radius: 10px; font-size:larger; color:green;"><strong>Resolved Tickets</strong>
                                            <div><strong>{{ $resolvedTickets }}</strong></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-3 border bg-light" style="border-radius: 10px; font-size:larger; color:red;"><strong>Closed Tickets</strong>
                                            <div><strong>{{ $closedTickets }}</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row justify-content-around">
                                <div class="product-index p-4" style="margin-top:30px; border-style:solid">
                                    <div id="chartContainer1" style="height: 350px; width: 450px;">
                                    </div>
                                </div>
                                <div class="product-index text-right p-4" style="margin-top:30px; margin-left:30px; border-style:solid">
                                    <div class="form-group">
                                        <label for="startDate" style="font-size:medium;"><strong>From:</strong></label>
                                        <input type="date" id="startDate" name="startDate" value="{{ now()->startOfYear()->toDateString() }}" required>

                                        <label class="ml-2" for="endDate" style="font-size:medium;"> <strong>To:</strong></label>
                                        <input type="date" id="endDate" name="endDate" value="{{  now()->toDateString() }}" required>
                                        <div id="chartContainer4" style="height: 350px; width: 550px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row justify-content-around">
                            <div class="product-index p-4" style="margin-top:20px; border-style:solid">
                                    <div id="chartContainer2" style="height: 350px; width: 450px;">
                                    </div>
                                </div>
                                <div class="product-index p-4" style="margin-top:20px; margin-left:30px; border-style:solid">
                                    <div id="chartContainer3" style="height: 350px; width: 550px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
@endsection

@push('scripts')
@push('scripts')
<script>
    function updateChartData(startDate, endDate) {
        $.ajax({
            url: '{{ route("engineer.dashboard") }}',
            type: 'GET',
            data: {
                startDate: startDate,
                endDate: endDate
            },
            dataType: 'json',
            success: function(response) {
                var chart = new CanvasJS.Chart("chartContainer4", {
                    animationEnabled: true,
                    title: {
                        text: "Tickets Created Over Date"
                    },
                    axisX: {
                        title: "Date",
                        valueFormatString: "DD MMM 'YY"
                    },
                    axisY: {
                        title: "Number of Tickets",
                        includeZero: false,
                        interval: 1,
                    },
                    data: [{
                        type: "spline",
                        toolTipContent: "<b>{x}</b>: {y} Ticket",
                        indexLabel: "{x}-{y}",
                        dataPoints: response.map(dp => ({
                            x: new Date(dp.label),
                            y: dp.y
                        }))
                    }]
                });
                chart.render();
            },
            error: function(xhr) {
                console.log("Error updating data.");
            }
        });
    }
    $(function() {
        // On page load, fetch data for the default date range.
        var initialStartDate = $('#startDate').val();
        var initialEndDate = $('#endDate').val();
        updateChartData(initialStartDate, initialEndDate);

        // Listener for date changes.
        $('#startDate, #endDate').change(function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            updateChartData(startDate, endDate);
        });
    });
</script>
@endpush

<script>
    window.onload = function() {
        // var chartType = document.getElementById("chart").value;
        var chart = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            title: {
                text: "Tickets by Status"
            },
            data: [{
                type: "doughnut",
                yValueFormatString: "#,##0.\"\"",
                toolTipContent: "<b>{label}</b>: {y}",
                showInLegend: "true",
                legendText: "{label}",
                indexLabel: "{label}-{y}",
                dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        var chart = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: true,
            title: {
                text: "Tickets by Priority"
            },
            axisX: {
                title: "Priority",
            },
            axisY: {
                interval: 1,
                title: "Ticket Count",
            },
            data: [{
                type: "bar",
                yValueFormatString: "#,##0.\"\"",
                toolTipContent: "<b>{label}</b>: {y}",
                indexLabel: "{label}-{y}",
                dataPoints: <?php echo json_encode($priorityData, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        var chart = new CanvasJS.Chart("chartContainer3", {
            animationEnabled: true,
            title: {
                text: "Assets by Maintenance Status"
            },
            axisX: {
                title: "Maintenance Status",
            },
            axisY: {
                title: "Asset Count ",
                interval: 1,
                includeZero: true,
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.\"\"",
                toolTipContent: "<b>{label}</b>: {y}",
                indexLabel: "{label}-{y}",
                dataPoints: <?php echo json_encode($assetData, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>

<script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
@endpush