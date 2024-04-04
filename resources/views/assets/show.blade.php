@extends('layouts.back')
@section('title', 'Asset Information')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Asset</h1>
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
                        <h4> Asset Information</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="AssetCusId" class="col-md-4 col-form-label text-md-end text-start"><strong>Customer Name</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->customer->firstname }} {{ $asset->customer->lastname }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetName" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Name</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->AssetName }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetSerialNum" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Serial No.</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->AssetSerialNum }}
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetTypeId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Type</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->assettype->AssetTypeName }}
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetDescription" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Description</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->AssetDescription }}
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetDepartmentId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Department</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->department->DepartmentName }}
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetOrganizationId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Organization</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->organization->OrganizationName}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="AssetCreatedAt" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Created At</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->AssetCreatedAt }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetLocation" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Location</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->AssetLocation }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetManagedBy" class="col-md-4 col-form-label text-md-end text-start"><strong>Managed By</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->staff->StaffName }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetPurchaseDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Purchase Date</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->AssetPurchaseDate }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetServiceType" class="col-md-4 col-form-label text-md-end text-start"><strong>Service Type</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <td>{{ $asset->servicetype->ServiceDesc }}</td>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetWarrantyExpiryDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Warreanty Expiry Date</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $asset->AssetWarrantyExpiryDate }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetImage" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Image</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <img style="width:80px; height:80px" src="{{asset('uploads/'.$asset->AssetImage)}}" alt="No Image Found!!">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection