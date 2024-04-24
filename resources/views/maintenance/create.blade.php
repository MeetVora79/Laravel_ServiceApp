@extends('layouts.back')
@section('title', 'Create Schedule')
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Maintenance Schedule</h1>
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
						<h5 class="modal-title">Create Schedule</h5>
						<div class="card-header-form">
							<a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
						</div>
					</div>
					<div class="modal-body">
						<form action="{{route('maintenance.store')}}" method="post">
							@csrf
							<div class="form-group">
								<label for="AssetId"><strong>Asset ID</strong></label>
								<div class="col-my-12">

									<input type="text" class="form-control" name="AssetId" id="AssetId" aria-describedby="AssetId" value="{{$asset->AssetId}}" required readonly>

									@if ($errors->has('AssetId'))
									<span class="text-danger">{{ $errors->first('AssetId') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group">
								<label for="AssignedId"><strong>Assigned Engineer</strong></label>
								<select class="form-control @error('AssignedId') is-invalid @enderror" aria-label="Asset Type" id="AssignedId" name="AssignedId" required>
									@forelse ($staffs as $staff)
									<option value="{{  $staff->StaffId }}" {{ (isset($asset) && $asset->AssetManagedBy == $staff->StaffId) ? 'selected' : '' }}>
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
								<input type="text" class="form-control" name="NumberOfServices" id="NumberOfServices" aria-describedby="NumberOfServices" value="{{$asset->NumberOfServices}}" required readonly>
							</div>

							<div class="form-group">
								<label for="ServiceDate"><strong>Service Date</strong></label>
								<select class="form-control @error('ServiceDate') is-invalid @enderror" aria-label="Service Date" id="ServiceDate" name="ServiceDate" required>
									<option value="">Select Date</option>
									@if($serviceDates->ServiceDate1)
									<option value="{{ $serviceDates->ServiceDate1 }}">
										{{ $serviceDates->ServiceDate1 }}
									</option>
									@endif
									@if($serviceDates->ServiceDate2)
									<option value="{{ $serviceDates->ServiceDate2 }}">
										{{ $serviceDates->ServiceDate2 }}
									</option>
									@endif
									@if($serviceDates->ServiceDate3)
									<option value="{{ $serviceDates->ServiceDate3 }}">
										{{ $serviceDates->ServiceDate3 }}
									</option>
									@endif
									@if($serviceDates->ServiceDate4)
									<option value="{{ $serviceDates->ServiceDate4 }}">
										{{ $serviceDates->ServiceDate4 }}
									</option>
									@endif
								</select>

								@error('ServiceDate')
								<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="Instruction"><strong>Instruction</strong></label>
								<input type="text" class="form-control" name="Instruction" id="Instruction" aria-describedby="ticketInstruction" placeholder="Give Your instruction here!!" value="{{old('Instruction')}}" required>
							</div>

							<button type="submit" class="btn btn-primary">Create Schedule</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


</section>
@endsection