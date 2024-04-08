@extends('layouts.back')
@section('title', 'Edit Asset')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Asset</h1>
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
                        <h4>Asset Information</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assets.update',$asset->AssetId) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="AssetCusId" class="col-md-4 col-form-label text-md-end text-start"><strong>Customer Name</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('assetmanagers') is-invalid @enderror select2 col-md-11" aria-label="Used By" id="assetmanagers" name="AssetCusId" required>
                                                <option>Select</option>
                                                @forelse ($customers as $customer)
                                                <option value="{{  $customer->CustomerId }}" {{ (isset($asset) && $asset->AssetCusId == $customer->CustomerId) ? 'selected' : '' }}>
                                                    {{ $customer->firstname }} {{ $customer->lastname }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('assetmanagers'))
                                            <span class="text-danger">{{ $errors->first('assetmanagers') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetName" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Name</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetName') is-invalid @enderror" id="AssetName" name="AssetName" value="{{ $asset->AssetName }}" required>
                                            @if ($errors->has('AssetName'))
                                            <span class="text-danger">{{ $errors->first('AssetName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetSerialNum" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Serial No.</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetSerialNum') is-invalid @enderror" id="AssetSerialNum" name="AssetSerialNum" value="{{ $asset->AssetSerialNum }}" required>
                                            @if ($errors->has('AssetSerialNum'))
                                            <span class="text-danger">{{ $errors->first('AssetSerialNum') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetTypeId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Type</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('assettypes') is-invalid @enderror select2 col-md-11" aria-label="Asset Type" id="assettypes" name="AssetTypeId" required>
                                                <option value="">Select Asset Type</option>
                                                @forelse ($assettypes as $type)
                                                <option value="{{  $type->AssetTypeId }}" {{ (isset($asset) && $asset->AssetTypeId == $type->AssetTypeId) ? 'selected' : '' }}>
                                                    {{ $type->AssetTypeName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetTypeId'))
                                            <span class="text-danger">{{ $errors->first('AssetTypeId') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetDescription" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Description</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetDescription') is-invalid @enderror" id="AssetDescription" name="AssetDescription" value="{{ $asset->AssetDescription }}" required>
                                            @if ($errors->has('AssetDescription'))
                                            <span class="text-danger">{{ $errors->first('AssetDescription') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetDepartmentId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Department</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('assetdepartments') is-invalid @enderror select2 col-md-11" aria-label="Asset Department" id="assetdepartments" name="AssetDepartmentId" required>
                                                <option value="">Select Department</option>
                                                @forelse ($assetdepartments as $dept)
                                                <option value="{{  $dept->DepartmentId }}" {{ (isset($asset) && $asset->AssetDepartmentId == $dept->DepartmentId) ? 'selected' : '' }}>
                                                    {{ $dept->DepartmentName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetDepartmentId'))
                                            <span class="text-danger">{{ $errors->first('AssetDepartmentId') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetOrganizationId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Organization</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('assetorganizations') is-invalid @enderror select2 col-md-11" aria-label="Asset Organization" id="assetorganizations" name="AssetOrganizationId" required>
                                                <option value="">Select Organization</option>
                                                @forelse ($assetorganizations as $org)
                                                <option value="{{  $org->OrganizationId }}" {{ (isset($asset) && $asset->AssetOrganizationId == $org->OrganizationId) ? 'selected' : '' }}>
                                                    {{ $org->OrganizationName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetOrganizationId'))
                                            <span class="text-danger">{{ $errors->first('AssetOrganizationId') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label for="AssetLocation" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Location</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetLocation') is-invalid @enderror" id="AssetLocation" name="AssetLocation" value="{{ $asset->AssetLocation }}" required>
                                            @if ($errors->has('AssetLocation'))
                                            <span class="text-danger">{{ $errors->first('AssetLocation') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetManagedBy" class="col-md-4 col-form-label text-md-end text-start"><strong>Managed By</strong></label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('assetmanagers') is-invalid @enderror select2 col-md-11" aria-label="Managed By" id="assetmanagers" name="AssetManagedBy" required>
                                                <option>Select</option>
                                                @forelse ($staffs as $staff)
                                                <option value="{{  $staff->StaffId }}" {{ (isset($asset) && $asset->AssetManagedBy == $staff->StaffId) ? 'selected' : '' }}>
                                                    {{ $staff->StaffName }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('assetmanagers'))
                                            <span class="text-danger">{{ $errors->first('assetmanagers') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetPurchaseDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Purchase Date</strong></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('AssetPurchaseDate') is-invalid @enderror" id="AssetPurchaseDate" name="AssetPurchaseDate" value="{{ $asset->AssetPurchaseDate }}" required>
                                            @if ($errors->has('AssetPurchaseDate'))
                                            <span class="text-danger">{{ $errors->first('AssetPurchaseDate') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetServiceTypeId" class="col-md-4 col-form-label text-md-end text-start"><strong>Service Type</strong></label>
                                        <div class="col-md-6">
                                        <select class="form-control @error('AssetServiceTypeId') is-invalid @enderror select2 col-md-11" aria-label="Managed By" id="AssetServiceTypeId" name="AssetServiceTypeId" required>
                                                <option>Select</option>
                                                @forelse ($services as $service)
                                                <option value="{{ $service->id }}" {{ (isset($asset) && $asset->AssetServiceTypeId == $service->id) ? 'selected' : '' }}>
                                                    {{ $service->ServiceDesc }}
                                                </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('AssetServiceTypeId'))
                                            <span class="text-danger">{{ $errors->first('AssetServiceTypeId') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetWarrantyExpiryDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Warranty Expiry Date</strong></label>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control @error('AssetWarrantyExpiryDate') is-invalid @enderror" id="AssetWarrantyExpiryDate" name="AssetWarrantyExpiryDate" value="{{ $asset->AssetWarrantyExpiryDate }}" required>
                                            @if ($errors->has('AssetWarrantyExpiryDate'))
                                            <span class="text-danger">{{ $errors->first('AssetWarrantyExpiryDate') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="AssetImage" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Image</strong></label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control @error('AssetImage') is-invalid @enderror" id="AssetImage" name="AssetImage" value="{{ $asset->AssetImage  }}" required>
                                            @if ($errors->has('AssetImage'))
                                            <span class="text-danger">{{ $errors->first('AssetImage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-3 row">
                                <input type="submit" class="offset-md-5 btn btn-primary" value="Update Asset">
                            </div>
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