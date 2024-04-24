@extends('layouts.back')
@section('title', 'Edit User')
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
                                    <input type="text" class="form-control @error('StaffName') is-invalid @enderror" id="StaffName" name="StaffName" value="{{ $staff->StaffName }}" required>
                                    @if ($errors->has('StaffName'))
                                    <span class="text-danger">{{ $errors->first('StaffName') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="mobile" class="col-md-2 col-form-label text-md-end text-start"><strong>Mobile No.</strong></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ $staff->mobile }}" required>
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-2 col-form-label text-md-end text-start"><strong>Email</strong></label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $staff->email }}" required>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="address" class="col-md-2 col-form-label text-md-end text-start"><strong>Address</strong></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $staff->address }}" required>
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
