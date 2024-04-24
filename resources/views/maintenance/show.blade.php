@extends('layouts.back')
@section('title', 'Maintenance Information')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Maintenance Information</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
            <div class="breadcrumb-item">Maintenance</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Maintenance Information</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body m-2">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="AssetName" class="col-md-4 col-form-label text-md-end text-start"><strong>Maintenance Id</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->AssetId }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetName" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Name</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->AssetName }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetSerialNum" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Serial No.</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->AssetSerialNum }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetCusId" class="col-md-4 col-form-label text-md-end text-start"><strong>Customer Name</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->customer->firstname }} {{ $schedule->asset->customer->lastname }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetManagedBy" class="col-md-4 col-form-label text-md-end text-start"><strong>Maintenance Engineer</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->staff->StaffName }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetSerialNum" class="col-md-4 col-form-label text-md-end text-start"><strong>Maintenance Status</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->maintenancestatus->StatusName }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetTypeId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Type</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->assettype->AssetTypeName }}
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetDescription" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Description</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->AssetDescription }}
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 row">
                                    <label for="AssetDepartmentId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Department</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->department->DepartmentName }}
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetOrganizationId" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Organization</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->organization->OrganizationName}}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetLocation" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Location</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->AssetLocation }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetPurchaseDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Purchase Date</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->AssetPurchaseDate }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetWarrantyExpiryDate" class="col-md-4 col-form-label text-md-end text-start"><strong>Warranty Expiry Date</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->AssetWarrantyExpiryDate }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetServiceType" class="col-md-4 col-form-label text-md-end text-start"><strong>Service Type</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        {{ $schedule->asset->servicetype->ServiceDesc }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetServiceType" class="col-md-4 col-form-label text-md-end text-start"><strong>Number of Service</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                    {{  $schedule->asset->NumberOfServices }}
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="AssetImage" class="col-md-4 col-form-label text-md-end text-start"><strong>Asset Image</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <img style="width:80px; height:80px" src="{{asset('uploads/'.$schedule->asset->AssetImage)}}" alt="No Image Found!!">
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