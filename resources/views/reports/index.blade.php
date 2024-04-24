@extends('layouts.back')
@section('title', 'Reports & Statistics')
@push('styles')
<style>
	.row {
		display: flex;
		justify-content: around;
		flex-wrap: wrap;
	}

	.product-index {
		flex: 1;
		min-width: 300px;
		box-sizing: border-box;
		padding: 20px;
		margin: 10px;
		overflow: auto;
	}

	#chartContainer1,
	#chartContainer2,
	#chartContainer3,
	#chartContainer4 {
		max-width: 100%;
		max-height: 100%;
	}
</style>

@endpush
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Reports & Statistics</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route('reports.index') }}">Reports</a></div>
		</div>
	</div>
	<div class="section-body">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4>Reports</h4>
					</div>
					<div class="container mt-2 ml-5">
						<h2>Generate Report</h2>
						<div class="row">
							<div class="col-md-5 p-3">
								<form action="{{ route('reports.generate') }}" method="POST">
									@csrf
									<div class="mb-3">
										<label for="reportType" class="form-label"><strong>Report Type</strong></label>
										<select class="form-control" id="reportType" name="reportType" required>
											<option value="Tickets">Tickets</option>
											<option value="Assets">Assets</option>
											<option value="Maintenance">Maintenance</option>
											<option value="Customers">Customers</option>
											<option value="Staff">Staff</option>
										</select>
									</div>
									<div class="mb-3">
										<label class="form-label"><strong>Export As</strong></label>
										<div class="d-flex align-items-center">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="exportType" id="pdf" value="PDF" checked>
												<label class="form-check-label" for="pdf">
													PDF
												</label>
											</div>
											<div class="form-check form-check-inline ml-3">
												<input class="form-check-input" type="radio" name="exportType" id="excel" value="Excel">
												<label class="form-check-label" for="excel">
													Excel
												</label>
											</div>
										</div>
									</div>
									<button type="submit" class="btn btn-primary">Generate Report</button>
							</div>

							<div class="col-md-5 p-3">
								<div class="mb-3">
									<label for="sDate" class="form-label"><strong>Start Date</strong></label>
									<input type="date" class="form-control" id="sDate" name="sDate" required onchange="updateEndDateMinimum()">
								</div>
								<div class="mb-3">
									<label for="eDate" class="form-label"><strong>End Date</strong></label>
									<input type="date" class="form-control" id="eDate" name="eDate" required>
								</div>
								</form>
							</div>
						</div>
					</div>
					<hr>
					<div class="card-header">
						<h4>Statistics</h4>
					</div>
					<div class="card-body mb-3">
						<div class="container">
							<div class="row ">
								<div class="product-index" style="margin-top:30px; border-style:solid">
									<div id="chartContainer1" style="height: 350px; width: 450px;">
									</div>
								</div>
								<div class="product-index text-right" style="margin-top:30px; margin-left:30px; border-style:solid">
									<div class="form-group">
										<label for="startDate" style="font-size:medium;"><strong>From:</strong></label>
										<input type="date" id="startDate" name="startDate" value="{{ now()->startOfYear()->toDateString() }}" required onchange="updateEndDateMin()">
										<label class="ml-2" for="endDate" style="font-size:medium;"> <strong>To:</strong></label>
										<input type="date" id="endDate" name="endDate" value="{{  now()->toDateString() }}" required>
										<div id="chartContainer4" style="height: 350px; width: 550px;">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="container">
							<div class="row">
								<div class="product-index " style="margin-top:20px; border-style:solid">
									<div id="chartContainer2" style="height: 350px; width: 450px;">
									</div>
								</div>
								<div class="product-index" style="margin-top:20px; margin-left:30px; border-style:solid">
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
function updateEndDateMinimum() {
    var startDate = document.getElementById('sDate').value;
    var endDateInput = document.getElementById('eDate');
    endDateInput.min = startDate;
}
</script>

<script>
function updateEndDateMin() {
    var startDateInput = document.getElementById('startDate').value;
    var endDateInput = document.getElementById('endDate');
    endDateInput.min = startDateInput; 
}
</script>

<script>
	function updateChartData(startDate, endDate) {
		$.ajax({
			url: '{{ route("reports.index") }}',
			type: 'GET',
			data: {
				startDate: startDate,
				endDate: endDate
			},
			options: {
				responsive: true,
				maintainAspectRatio: false
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
		var initialStartDate = $('#startDate').val();
		var initialEndDate = $('#endDate').val();
		updateChartData(initialStartDate, initialEndDate);

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
			}],
			options: {
				responsive: true,
				maintainAspectRatio: false
			}
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
				// interval: 1,
				title: "Ticket Count",
			},
			data: [{
				type: "column",
				yValueFormatString: "#,##0.\"\"",
				toolTipContent: "<b>{label}</b>: {y}",
				indexLabel: "{label}-{y}",
				dataPoints: <?php echo json_encode($priorityData, JSON_NUMERIC_CHECK); ?>
			}],
			options: {
				responsive: true,
				maintainAspectRatio: false
			}
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
				type: "bar",
				yValueFormatString: "#,##0.\"\"",
				toolTipContent: "<b>{label}</b>: {y}",
				indexLabel: "{label}-{y}",
				dataPoints: <?php echo json_encode($assetData, JSON_NUMERIC_CHECK); ?>
			}],
			options: {
				responsive: true,
				maintainAspectRatio: false
			}
		});
		chart.render();
	}
</script>
<script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
@endpush