@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
<section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="card card-primary">
            <div class="card-header"><h4>Reset Password</h4></div>
            <div class="card-body">
              <form method="POST" action="{{ route('setpwd') }}" >
                @csrf
                @if($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email" tabindex="1" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div class="form-group">
                  <div class="d-block">
                      <label for="password" class="control-label">New Password</label>
                  </div>
                  <input id="password" type="password" tabindex="2" class="form-control" name="password" required autocomplete="new-password">
                </div>

				<div class="form-group">
				<div class="d-block">
                      <label for="password2" class="control-label">Confirm New Password</label>
                  </div>
                    <input id="password2" type="password" tabindex="2" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                   Set Password
                  </button>
                </div>
              </form>

            </div>
          </div>
          <div class="simple-footer">
            Copyright &copy; 2024,&nbsp; All Rights Reserved.
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
