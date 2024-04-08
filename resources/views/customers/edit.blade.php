@extends('layouts.back')
@section('title', 'Edit Customer')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
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
                        <h4>Customer Information</h4>
                        <div class="card-header-form">
                                <a href="{{ route('customers.index') }}" class="btn btn-primary my-2"><i class="bi bi-arrow-left"></i>Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customers.update', $customer->CustomerId) }}" method="post">
                            @csrf
                            @method("PUT")

                            <div class="mb-3 row">
                                <label for="firstname" class="col-md-2 col-form-label text-md-end text-start"><strong>First Name</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ $customer->firstname }}" required>
                                    @if ($errors->has('firstname'))
                                        <span class="text-danger">{{ $errors->first('firstname') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="lastname" class="col-md-2 col-form-label text-md-end text-start"><strong>Last Name</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ $customer->lastname }}" required>
                                    @if ($errors->has('lastname'))
                                        <span class="text-danger">{{ $errors->first('lastname') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="mobile" class="col-md-2 col-form-label text-md-end text-start"><strong>Mobile No.</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ $customer->mobile }}" required>
                                    @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-2 col-form-label text-md-end text-start"><strong>Email</strong></label>
                                <div class="col-md-4">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $customer->email }}" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="address" class="col-md-2 col-form-label text-md-end text-start"><strong>Address</strong></label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $customer->address }}" required>
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>  

                            <div class="m-4 row">
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
