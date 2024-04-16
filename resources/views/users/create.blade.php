@extends('layouts.back')
@section('title', 'Create Staff')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>New Staff</h1>
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
                        <h4>Staff Information</h4>
                        <div class="card-header-form">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="post">
                            @csrf

                            <div class="mb-3 row">
                                <label for="StaffName" class="col-md-2 col-form-label text-md-end text-start"><strong>Name</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('StaffName') is-invalid @enderror" id="StaffName" name="StaffName" value="{{ old('StaffName') }}" required>
                                    @if ($errors->has('StaffName'))
                                        <span class="text-danger">{{ $errors->first('StaffName') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="mobile" class="col-md-2 col-form-label text-md-end text-start"><strong>Mobile No.</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
                                    @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-2 col-form-label text-md-end text-start"><strong>Email</strong></label>
                                <div class="col-md-4">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="address" class="col-md-2 col-form-label text-md-end text-start"><strong>Address</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="role" class="col-md-2 col-form-label text-md-end text-start"><strong>Roles</strong></label>
                                <div class="col-md-4">
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option>Select Role</option>
                                        @forelse ($roles as $role)
                                            <option value="{{ $role->id }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
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

                            <div class="m-4 row">
                                <input type="submit" class="offset-md-2 btn btn-primary" value="Add Staff">
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

