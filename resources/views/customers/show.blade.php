@extends('layouts.back')
@section('title', 'Customer Information')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Customer</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
            <div class="breadcrumb-item">Customers</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Customer Information</h4>
                        <div class="card-header-form">
                            <a href="{{ route('customers.index') }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="mb-3 row">
                            <label for="firstname" class="col-md-2 col-form-label text-md-end text-start"><strong>First Name :</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $customer->firstname }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="lastname" class="col-md-2 col-form-label text-md-end text-start"><strong>Last Name :</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $customer->lastname }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="mobile" class="col-md-2 col-form-label text-md-end text-start"><strong>Mobile No. :</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $customer->mobile }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-2 col-form-label text-md-end text-start"><strong>Email :</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $customer->email }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="address" class="col-md-2 col-form-label text-md-end text-start"><strong>Address :</strong></label>
                            <div class="col-md-4" style="line-height: 35px;">
                                {{ $customer->address }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection