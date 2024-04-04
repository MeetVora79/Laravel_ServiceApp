@extends('layouts.back')
@section('title', 'Assign Ticket')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Assign Ticket</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
			<div class="breadcrumb-item">Assign</div>
		</div>
	</div>

	<div class="section-body">
		<div class="col-12 col-lg-5	">
			<div class="modal-dialog" role="document">
				<div class="modal-content p-3">
					<div class="modal-header">
						<h5 class="modal-title">Assign Ticket</h5>
						<div class="card-header-form">
							<a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
						</div>
					</div>
					<div class="modal-body">
						<form action="{{route('tickets.assignee')}}" method="post">
							@csrf
							<div class="form-group">
								<label for="TicketId">Ticket ID</label>
								<div class="col-my-12">

									<input type="text" class="form-control" name="TicketId" id="TicketId" aria-describedby="TicketId" value="{{$ticket->TicketId}}">

									@if ($errors->has('TicketId'))
									<span class="text-danger">{{ $errors->first('TicketId') }}</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label for="AssignId">Assign To</label>
								<div class="col-my-12">
									<select class="form-control @error('AssignId') is-invalid @enderror select2" aria-label="Assign To" id="AssignId" name="AssignId" placeholder="Assignee To">
										<option>Select</option>
										@forelse ($staffs as $staff)
										<option value="{{  $staff->StaffId }}">
											{{ $staff->StaffName }}
										</option>
										@empty
										@endforelse
									</select>
									@if ($errors->has('AssignId'))
									<span class="text-danger">{{ $errors->first('AssignId') }}</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label for="ServiceDate">Service Date</label>
								<input type="Date" class="form-control" name="ServiceDate" id="ServiceDate" aria-describedby="ticketserviceDate">
							</div>
							<div class="form-group">
								<label for="TimeSlot">Time Slot</label>
								<input type="time" class="form-control" name="TimeSlot" id="TimeSlot" aria-describedby="tickettimeSlot">
							</div>
							<div class="form-group">
								<label for="Instruction">Instruction</label>
								<input type="text" class="form-control" name="Instruction" id="Instruction" aria-describedby="ticketInstruction" placeholder="Give Your instruction here!!">
							</div>

							<button type="submit" class="btn btn-primary">Assign</button>
						</form>
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

@endpush