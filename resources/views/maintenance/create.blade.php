@extends('layouts.back')
@section('title', 'Create Schedule')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
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
									<option>Select Type</option>
									@forelse ($staffs as $staff)
									<option value="{{  $staff->StaffId }}" {{ (isset($asset) && $asset->AssetManagedBy == $staff->StaffId) ? 'selected' : '' }}>
										{{ $staff->StaffName }}
									</option>
									@empty
									@endforelse
								</select>
								@if ($errors->has('AssetTypeId'))
								<span class="text-danger">{{ $errors->first('AssetTypeId') }}</span>
								@endif
							</div>

							<div class="form-group">
								<label for="NumberOfServices"><strong>Number of Services</strong></label>
								<input type="text" class="form-control" name="NumberOfServices" id="NumberOfServices" aria-describedby="NumberOfServices" value="{{$asset->NumberOfServices}}" required readonly>
							</div>
							<div id="datePickersContainer"></div>

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
@push('scripts')

<script>
	$(document).ready(function() {
		const numberOfServices = $('#NumberOfServices').val();
		const datePickersContainer = $('#datePickersContainer');
		datePickersContainer.empty();

		for (let i = 0; i < numberOfServices; i++) {
			const date = new Date();
			date.setMonth(date.getMonth() + 3 * (i + 1));
			const formattedDate = date.toISOString().split('T')[0];

			const datePickerHtml = `
            <div class="form-group">
                <label for="ServiceDate${i+1}"><strong>Service Date ${i+1}</strong></label>
                <input type="date" class="form-control" name="ServiceDate[]" id="ServiceDate${i+1}" value="${formattedDate}" required>
            </div>
        `;
			datePickersContainer.append(datePickerHtml);
		}
	});
</script>

@endpush