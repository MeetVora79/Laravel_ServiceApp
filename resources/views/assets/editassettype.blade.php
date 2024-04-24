@extends('layouts.back')
@section('title', 'Edit AssetType')
@section('content')
<section class="section">
	<div class="section-header">
		<h1>Edit AssetType</h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
			<div class="breadcrumb-item">Assets</div>
		</div>
	</div>
	<div class="section-body">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4>Edit Asset Type</h4>
						<div class="card-header-form">
							<a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
						</div>
					</div>
					<div class="card-body">
						<form action="{{ route('updateAssetType', $assettype->AssetTypeId) }}" method="post">
							@csrf
							@method('PUT')
							<div class="mb-3 mt-2 row">
								<label for="AssetTypeName" class="col-md-2 col-form-label text-start"><strong>Asset Type:</strong></label>
								<div class="col-md-4">
									<input type="text" class="form-control @error('AssetTypeName') is-invalid @enderror" id="AssetTypeName" name="AssetTypeName" value="{{ $assettype->AssetTypeName }}" required>
									@if ($errors->has('AssetTypeName'))
									<span class="text-danger">{{ $errors->first('AssetTypeName') }}</span>
									@endif
								</div>
								<input type="submit" class="offset-md-1 btn btn-primary" value="Update">
							</div>
							<div class="mb-3 row"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
