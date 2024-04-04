@extends('layouts.back')
@section('title', 'Edit User')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route(Auth::user()->getDashboardRouteName()) }}">Dashboard</a></div>
        <div class="breadcrumb-item">users</div>
      </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User</h4>
                        <div class="card-header-form">
                                <a href="{{ route('users.index') }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $staff->StaffId) }}" method="post">
                            @csrf
                            @method("PUT")

                            <div class="mb-3 row">
                                <label for="StaffName" class="col-md-2 col-form-label text-md-end text-start"><strong>Name</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('StaffName') is-invalid @enderror" id="StaffName" name="StaffName" value="{{ $staff->StaffName }}">
                                    @if ($errors->has('StaffName'))
                                        <span class="text-danger">{{ $errors->first('StaffName') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-2 col-form-label text-md-end text-start"><strong>Email Address</strong></label>
                                <div class="col-md-4">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $staff->email }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="role" class="col-md-2 col-form-label text-md-end text-start"><strong>Roles</strong></label>
                                <div class="col-md-4">
                                    <select class="form-control @error('role') is-invalid @enderror select2 col-md-11" id="role" name="role">
                                    <option>Select Role</option>
                                        @forelse ($roles as $role)                                         
                                            <option value="{{ $role->id }}" {{ (isset($staff) && $staff->role  == $role->id ) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password" class="col-md-2 col-form-label text-md-end text-start"><strong>Password</strong></label>
                                <div class="col-md-4">
                                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{$staff->password}}">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password_confirmation" class="col-md-2 col-form-label text-md-end text-start"><strong>Confirm Password</strong></label>
                                <div class="col-md-4">
                                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{$staff->password}}">
                                </div>
                            </div>

                            <div class="m-4 row">
                                <input type="submit" class="offset-md-2 btn btn-primary" value="Update Staff">
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
