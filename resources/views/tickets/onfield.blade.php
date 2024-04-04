@extends('layouts.back')
@section('title', 'TicketInfo')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Ticket Information</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
			<div class="breadcrumb-item"></div>
		</div>
	</div>
	<div class="section-body">
		<div class="col">
			<div class="card-group">
				<div class="card p-3">
					<div class="card-header">
						<h4>Assigned Ticket Information</h4>

						<div class="card-header-form">
							<a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
						</div>
					</div>
					<form action="{{route('tickets.assignee')}}" method="post">
						@csrf
						<table class="table table-striped">
							<tbody>
								<tr>
									<td><label for="TicketId" class="col-md-4"><strong>Ticket Id :</strong></label><strong>{{ $allocation->TicketId }}</strong></td>
									<td><label for="TicketSubject" class="col-md-4 "><strong>Subject :</strong></label>
										<strong>{{ $allocation->ticket->TicketSubject }}</strong>
									</td>
									<td><label for="TicketDescription" class="col-md-4 "><strong>Description :</strong></label>
										<strong>{{ $allocation->ticket->TicketDescription }}</strong>
									</td>
								</tr>

								<tr>
									<td><label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Customer Name :</strong></label>
										<strong>{{ $allocation->ticket->customer->firstname }} {{ $allocation->ticket->customer->lastname }}</strong>
									</td>
									<td><label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Mobile Number:</strong></label>
										<strong>{{ $allocation->ticket->customer->mobile  }}</strong>
									</td>
									<td><label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Address :</strong></label>
										<strong>{{ $allocation->ticket->customer->address }}</strong>
									</td>
								</tr>

								<tr>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Id :</strong></label>
										<strong>{{ $allocation->ticket->asset->AssetId }}</strong>
									</td>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Name :</strong></label>
										<strong>{{ $allocation->ticket->asset->AssetName }}</strong>
									</td>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Type :</strong></label>
										<strong>{{ $allocation->ticket->asset->assettype->AssetTypeName }}</strong>
									</td>
								</tr>

								<tr>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Priority :</strong></label>
										<strong>{{ $allocation->ticket->priorityticket->PriorityName}}</strong>
									</td>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Status :</strong></label>
										<strong>{{ $allocation->ticket->statusticket->StatusName }}</strong>
									</td>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Attachments :</strong></label><img style="width:80px; height:60px" src="{{asset('uploads/'.$allocation->ticket->Attachments)}}" alt="No Image Found!!">
									</td>
								</tr>

								<tr>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Service Date:</strong></label>
										<strong>{{ $allocation->ServiceDate }}</strong>
									</td>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Time Slot:</strong></label>
										<strong>{{ $allocation->TimeSlot }}</strong>
									</td>
									<td><label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Instruction :</strong></label>
										<strong>{{ $allocation->Instruction }}</strong>
									</td>
								</tr>

								<!-- <tr>
									<td><span><label for="name" class="p-3"><strong>Comments :</strong></label>
											<input type="text" class="form-control" name="Comments" id="Comments" placeholder="Comments here!!"></span>
									</td>

								</tr> -->
							</tbody>


						</table>
						<!-- <button type="submit" class="btn btn-primary m-3">Submit</button>
						<a href="{{ url()->previous() }}" class="btn btn-danger m-3">Cancel</a> -->
					</form>

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