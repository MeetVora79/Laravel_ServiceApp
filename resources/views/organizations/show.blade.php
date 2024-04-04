@extends('layouts.back')
@section('title', 'Organization Information')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Organizations</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">Organizations</div>
      </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        
                            <h4> Organizations Information</h4>
                            <div class="card-header-form">
                                 <a href="{{ route('organizations.index') }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                            </div>
                          
                    </div>
                    <div class="card-body">

                            <div class="mb-3 row">
                                <label for="Department" class="col-md-2 col-form-label text-md-end text-start"><strong>Organization Name:</strong></label>
                                <div class="col-md-4" style="line-height: 35px;">
                                    {{ $organization->OrganizationName}}
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
