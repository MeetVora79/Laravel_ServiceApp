@extends('layouts.back')
@section('title', 'Edit Schedule')
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

									<input type="text" class="form-control" name="AssetId" id="AssetId" aria-describedby="AssetId" value="{{$schedule->AssetId}}" required readonly>

									@if ($errors->has('AssetId'))
									<span class="text-danger">{{ $errors->first('AssetId') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="AssignedId"><strong>Assigned Engineer</strong></label>
								<select class="form-control @error('AssignedId') is-invalid @enderror" aria-label="Asset Type" id="AssignedId" name="AssignedId" required>
									<option>Select Type</option>
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

							<div class="form-group">
								<label for="NumberOfServices"><strong>Number of Services</strong></label>
								<input type="text" class="form-control" name="NumberOfServices" id="NumberOfServices" aria-describedby="NumberOfServices" value="{{$schedule->asset->NumberOfServices}}" required readonly>
							</div>
							<div id="datePickersContainer">
								<div class="form-group">
									<label for="ServiceDate"><strong>Service Date</strong></label>
									<input type="date" class="form-control" name="ServiceDate" id="ServiceDate" value="{{$schedule->ServiceDate}}" required>
								</div>
							</div>

							<div class="form-group">
								<label for="Instruction">Instruction</label>
								<input type="text" class="form-control" name="Instruction" id="Instruction" aria-describedby="ticketInstruction" placeholder="Give Your instruction here!!" value="{{$schedule->Instruction}}" required>
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
