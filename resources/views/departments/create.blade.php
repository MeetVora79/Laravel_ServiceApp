@extends('layouts.back')
@section('title', 'Create Department')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>New Department</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">Departments</div>
      </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Department</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('departments.store') }}" method="post">
                            @csrf

                            <div class="mb-3 row">
                                <label for="DepartmentName" class="col-md-2 col-form-label text-md-end text-start"><strong>Department Name:</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('DepartmentName') is-invalid @enderror" id="DepartmentName" name="DepartmentName" value="{{ old('DepartmentName') }}" required>
                                    @if ($errors->has('DepartmentName'))
                                        <span class="text-danger">{{ $errors->first('DepartmentName') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="m-3 row">
                                <input type="submit" class="offset-md-2 btn btn-primary" value="Add Department">
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

