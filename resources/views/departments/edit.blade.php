@extends('layouts.back')
@section('title', 'Edit Department')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Department</h1>
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
                        <h4>Edit Department</h4>
                        <div class="card-header-form">
                                <a href="{{ route('departments.index') }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('departments.update', $department->DepartmentId) }}" method="post">
                            @csrf
                            @method("PUT")

                            <div class="mb-3 row">
                                <label for="DepartmentName" class="col-md-2 col-form-label text-md-end text-start"><strong>Department Name:</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('DepartmentName') is-invalid @enderror" id="DepartmentName" name="DepartmentName" value="{{ $department->DepartmentName }}" required>
                                    @if ($errors->has('DepartmentName'))
                                        <span class="text-danger">{{ $errors->first('DepartmentName') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="m-3 row">
                                <input type="submit" class="offset-md-2 btn btn-primary" value="Update ">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

