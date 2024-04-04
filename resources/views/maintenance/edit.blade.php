@extends('layouts.back')
@section('title', 'Edit Schedule')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Maintenace Schedule</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
			<div class="breadcrumb-item">Schedule</div>
		</div>
	</div>

	<div class="section-body">
		<div class="col-12 col-lg-5	">
			<div class="modal-dialog" role="document">
				<div class="modal-content p-3">
					<div class="modal-header">
						<h5 class="modal-title">Edit Schedule</h5>
						<div class="card-header-form">
							<a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
						</div>
					</div>
					<div class="modal-body">
						<form action="{{route('maintenance.update',$schedule->ScheduleId)}}" method="post">
							@csrf
							@method('PUT')
							<div class="form-group">
								<label for="AssetId">Asset ID</label>
								<div class="col-my-12">

									<input type="text" class="form-control" name="AssetId" id="AssetId" aria-describedby="AssetId" value="{{$schedule->AssetId}}" >

									@if ($errors->has('AssetId'))
									<span class="text-danger">{{ $errors->first('AssetId') }}</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label for="AssignedId">Maintenance Engineer</label>
								<div class="col-my-12">
									<select class="form-control @error('AssignedId') is-invalid @enderror select2" aria-label="Assign To" id="AssignedId" name="AssignedId" placeholder="Assign Maintenance To">
										<option>Select</option>
										@forelse ($staffs as $staff)
										<option value="{{  $staff->StaffId }}" {{ (isset($schedule) && $schedule->AssignedId == $staff->StaffId) ? 'selected' : '' }}>
											{{ $staff->StaffName }}
										</option>
										@empty
										@endforelse
									</select>
									@if ($errors->has('AssignedId'))
									<span class="text-danger">{{ $errors->first('AssignedId') }}</span>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label for="ServiceDate">Service Date</label>
								<input type="Date" class="form-control" name="ServiceDate" id="ServiceDate" aria-describedby="ticketserviceDate" value="{{$schedule->ServiceDate}}">
							</div>
							<div class="form-group">
								<label for="TimeSlot">Time Slot</label>
								<input type="time" class="form-control" name="TimeSlot" id="TimeSlot" aria-describedby="tickettimeSlot" value="{{$schedule->TimeSlot}}">
							</div>
							<div class="form-group">
								<label for="Instruction">Instruction</label>
								<input type="text" class="form-control" name="Instruction" id="Instruction" aria-describedby="ticketInstruction" placeholder="Give Your instruction here!!" value="{{$schedule->Instruction}}">
							</div>

							<button type="submit" class="btn btn-primary">Update</button>
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