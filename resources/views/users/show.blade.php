@extends('layouts.back')
@section('title', 'Staff Information')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Staff</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
            <div class="breadcrumb-item">Staff</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Staff Information</h4>
                        <div class="card-header-form">
                            <a href="{{ route('users.index') }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $staff->StaffName }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="mobile" class="col-md-2 col-form-label text-md-end text-start"><strong>Mobile No. :</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $staff->mobile }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-2 col-form-label text-md-end text-start"><strong>Email:</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $staff->email }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="address" class="col-md-2 col-form-label text-md-end text-start"><strong>Address :</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $staff->address }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="roles" class="col-md-2 col-form-label text-md-end text-start"><strong>Roles:</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                <span class="badge bg-primary">{{ $staff->roles->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection