@extends('layouts.back')
@section('title', 'Allocated Tickets')
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
		<h1>Allocated Tickets</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
			<div class="breadcrumb-item">Tickets</div>
		</div>
	</div>

	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header  justify-content-between">
						<h4>List of Allocated Tickets</h4>
						<div class="search-box form-inline search-element">
							<form action="{{ route('tickets.allocation') }}" method="GET">
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
									<th scope="col"> Allocation Id<a href="{{ route('tickets.allocation', ['sort' => 'AllocationId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a> </th>
									<th scope="col">Ticket Id<a href="{{ route('tickets.allocation', ['sort' => 'TicketId', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
									<th scope="col">Assign To</th>
									<th scope="col">Ticket Status</th>
									<th scope="col">Service Date<a href="{{ route('tickets.allocation', ['sort' => 'ServiceDate', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
									<th scope="col">Time Slot<a href="{{ route('tickets.allocation', ['sort' => 'TimeSlot', 'direction' => $nextDirection]) }}"><i class="fa fa-sort"></i></a></th>
									<th scope="col">Instruction</th>
									<th scope="col">Action</th>
								</tr>
								@forelse ($allocation as $allocate)
								<tr>
									<!-- <th scope="row">{{ $loop->iteration }}</th> -->
									<td>{{ $allocate->AllocationId  }}</td>
									<td>{{ $allocate->TicketId  }}</td>
									<td>{{ $allocate->staff->StaffName }}</td>
									<td>{{ $allocate->ticket->statusticket->StatusName}}</td>
									<td>{{ $allocate->ServiceDate }}</td>
									<td>{{ $allocate->TimeSlot }}</td>
									<td>{{ $allocate->Instruction }}</td>
									<td>
										<form action="{{ route('tickets.allocationDelete',  $allocate->AllocationId) }}" method="post">
											@csrf
											@method('DELETE')

											<a href="{{ route('tickets.onfield',  $allocate->AllocationId) }}" class="btn btn-warning btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="bi bi-eye"></i> </a>

											@if(auth()->user()->role == 1 || auth()->user()->role == 2)
											<a href="{{ route('tickets.editassign',  $allocate->AllocationId) }}" class="btn btn-primary btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bi bi-pencil-square"></i> </a>
											@endif

											@if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3)
											<div class="dropdown">
												<button type="button" class="btn btn-info btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-arrow-left-right"></i>
												</button>
												<ul class="dropdown-menu">
													<li><a href="#" class="dropdown-item my-2">Change Status</a>
														<ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">
															<li><a href="{{ route('changeStatus',['ticket' => $allocate->TicketId , 'status' => 'open']) }}" class="dropdown-item my-2">Open</a></li>
															<li><a href="{{ route('changeStatus',['ticket' => $allocate->TicketId, 'status' => 'closed']) }}" class="dropdown-item my-2">Closed</a></li>
															<li><a href="{{ route('changeStatus',['ticket' =>  $allocate->TicketId, 'status' => 'resolved']) }}" class="dropdown-item my-2">Resolved</a></li>
														</ul>
													</li>
													<!-- <li><a href="{{ route('tickets.index') }}" class="dropdown-item my-2">Merge Tickets</a></li>
													<li><a href="{{ route('tickets.index') }}" class="dropdown-item my-2">Forward Tickets</a></li> -->
												</ul>
											</div>
											@endif

											@if(auth()->user()->role == 1 || auth()->user()->role == 2)
											<button type="submit" class="btn btn-danger btn-sm m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Do you want to delete this Allocation?');"><i class="bi bi-trash"></i> </button>
											@endif

										</form>
									</td>
								</tr>
								@empty
								<td colspan="5">
									<span class="text-danger">
										<strong>No Allocation Found!</strong>
									</span>
								</td>
								@endforelse
							</table>
							{{ $allocation->links() }}
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
			window.location.href = 'http://127.0.0.1:8000/tickets/assigned/list';
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