@extends('layouts.back')
@section('title', 'Manage Schedule')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
<style>
	.dropdown-menu li {
		position: relative;
	}

	.dropdown-menu .dropdown-submenu {
		display: none;
		position: absolute;
		left: 100%;
		top: -7px;
	}

	.dropdown-menu .dropdown-submenu-left {
		right: 100%;
		left: auto;
	}

	.dropdown-menu>li:hover>.dropdown-submenu {
		display: block;
	}

	.dropdown-hover:hover>.dropdown-menu {
		display: inline-block;
	}

	.dropdown-hover>.dropdown-toggle:active {
		/*Without this, clicking will make it sticky*/
		pointer-events: none;
	}

	.search-box {
		position: relative;
		display: inline-block;
	}

	.clear-btn {
		position: absolute;
		right: 60px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		background-color: transparent;
		border: none;
	}

	.clear-btn:hover {
		color: red;
	}
</style>

@endpush
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Scheduled Maintenance</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
			<div class="breadcrumb-item">Scheduled</div>
		</div>
	</div>

	<div class="section-body">

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header justify-content-between">
						<h4>Scheduled Maintenance</h4>
						<div class="search-box form-inline search-element">
							<form action="{{ route('myschedule') }}" method="GET">
								<input class="form-control" type="text" name="searchTerm" id="searchTerm" placeholder="Search..." value="{{ request('searchTerm', '') }}" aria-label="Search" data-width="250" required> <span class="clear-btn" onclick="clearAndRedirect()" style="display: none;">×</span>
								<button class="btn form-control" type="submit"><i class="fas fa-search"></i></button>
							</form>
						</div>
						<div class="card-header-form">
							<a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-striped">
								<tr>
									<th scope="col"><a href="{{ route('maintenance.scheduled', ['sort' => 'ScheduleId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a>Schedule Id</th>
									<th scope="col"><a href="{{ route('maintenance.scheduled', ['sort' => 'AssetId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a>Asset Id</th>
									<th scope="col">Customer Name</th>
									<th scope="col">Maintenance Engineer</th>
									<th scope="col">Maintenance Status</th>
									<th scope="col"><a href="{{ route('maintenance.scheduled', ['sort' => 'ServiceDate', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a>Service Date</th>
									<th scope="col"><a href="{{ route('maintenance.scheduled', ['sort' => 'TimeSlot', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a>Time Slot</th>
									<th scope="col">Instruction</th>
									<th scope="col">Action</th>
								</tr>
								@forelse ($schedules as $schedule)
								<tr>

									<td>{{ $schedule->ScheduleId  }}</td>
									<td>{{ $schedule->AssetId  }}</td>
									<td>{{ $schedule->asset->customer->firstname }} {{ $schedule->asset->customer->lastname }}</td>
									<td>{{ $schedule->staff->StaffName }}</td>
									<td>{{ $schedule->maintenancestatus->StatusName }}</td>
									<td>{{ $schedule->ServiceDate }}</td>
									<td>{{ $schedule->TimeSlot }}</td>
									<td>{{ $schedule->Instruction }}</td>
									<td>
										<form action="{{ route('maintenance.destroy',  $schedule->ScheduleId) }}" method="post">
											@csrf
											@method('DELETE')

											<a href="{{ route('maintenance.show',  $schedule->ScheduleId) }}" class="btn btn-warning btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i> </a>

											@if(auth()->user()->role == 1 || auth()->user()->role == 2)
											<a href="{{ route('maintenance.edit',  $schedule->ScheduleId) }}" class="btn btn-primary btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i> </a>
											@endif

											@if(auth()->user()->role == 1 || auth()->user()->role == 2)
											<div class="dropdown">
												<button type="button" class="btn btn-info btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-arrow-left-right"></i>
												</button>
												<ul class="dropdown-menu">
													<li><a href="#" class="dropdown-item my-2">Change Maintenance Status</a>
														<ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">
															<li><a href="{{ route('maintenanceStatus',['schedule' => $schedule->ScheduleId , 'status' => 'completed']) }}" class="dropdown-item my-2">Completed</a></li>
															<li><a href="{{ route('maintenanceStatus',['schedule' => $schedule->ScheduleId , 'status' => 'scheduled']) }}" class="dropdown-item my-2">Scheduled</a></li>
															<li><a href="{{ route('maintenanceStatus',['schedule' =>  $schedule->ScheduleId , 'status' => 'unscheduled']) }}" class="dropdown-item my-2">Unscheduled</a></li>
														</ul>
													</li>
												</ul>
											</div>
											@endif

											@if(auth()->user()->role == 3)
											<div class="dropdown">
												<button type="button" class="btn btn-info btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-arrow-left-right"></i>
												</button>
												<ul class="dropdown-menu">
													<li><a href="#" class="dropdown-item my-2">Change Maintenance Status</a>
														<ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">
															<li><a href="{{ route('StatusUpdate',['schedule' => $schedule->ScheduleId , 'status' => 'completed']) }}" class="dropdown-item my-2">Completed</a></li>
															<li><a href="{{ route('StatusUpdate',['schedule' => $schedule->ScheduleId , 'status' => 'scheduled']) }}" class="dropdown-item my-2">Scheduled</a></li>
															<li><a href="{{ route('StatusUpdate',['schedule' =>  $schedule->ScheduleId , 'status' => 'unscheduled']) }}" class="dropdown-item my-2">Unscheduled</a></li>
														</ul>
													</li>
												</ul>
											</div>
											@endif

											@if(auth()->user()->role == 1 || auth()->user()->role == 2)
											<button type="submit" class="btn btn-danger btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Do you want to delete this Schedule?');"><i class="bi bi-trash"></i> </button>
											@endif

										</form>
									</td>
								</tr>
								@empty
								<td colspan="5">
									<span class="text-danger">
										<strong>No Schedule Found!</strong>
									</span>
								</td>
								@endforelse
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script>
	$(document).ready(function() {
		$('.select2').select2();
	});
</script>
<script>
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var searchTermInput = document.getElementById('searchTerm');
		var cancelButton = document.querySelector('.clear-btn');

		// Show the cancel button when the input field is focused or has text.
		function toggleCancelButton() {
			if (searchTermInput.value.length > 0 || searchTermInput === document.activeElement) {
				cancelButton.style.display = 'inline';
			} else {
				cancelButton.style.display = 'none';
			}
		}

		// Clear the input and redirect, or just hide the button on clear
		function clearAndRedirect() {
			searchTermInput.value = '';
			toggleCancelButton();
			searchTermInput.focus();
			window.location.href = 'http://127.0.0.1:8000/maintenance';
		}

		// Event listeners
		searchTermInput.addEventListener('input', toggleCancelButton);
		searchTermInput.addEventListener('focus', toggleCancelButton);
		searchTermInput.addEventListener('blur', toggleCancelButton);

		toggleCancelButton();
		cancelButton.onclick = clearAndRedirect;
	});
</script>

@endpush