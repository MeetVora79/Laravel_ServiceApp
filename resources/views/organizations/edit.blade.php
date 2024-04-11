@extends('layouts.back')
@section('title', 'Edit Organization')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
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
                        <h4>Edit Organization</h4>
                        <div class="card-header-form">
                                <a href="{{ route('organizations.index') }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('organizations.update', $organization->OrganizationId) }}" method="post">
                            @csrf
                            @method("PUT")

                            <div class="mb-3 row">
                                <label for="OrganizationName" class="col-md-2 col-form-label text-md-end text-start"><strong>Organizations Name:</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('OrganizationName') is-invalid @enderror" id="OrganizationName" name="OrganizationName" value="{{ $organization->OrganizationName }}" required>
                                    @if ($errors->has('OrganizationName'))
                                        <span class="text-danger">{{ $errors->first('OrganizationName') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="m-3 row">
                                <input type="submit" class="offset-md-2 btn btn-primary" value="Update">
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
