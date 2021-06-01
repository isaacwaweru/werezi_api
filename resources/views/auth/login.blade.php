@extends('layouts.auth')

@section('content')
<div class="container h-100-vh">
  <div class="row align-items-md-center h-100-vh">
      <div class="col-lg-6 d-none d-lg-block">
          <img class="img-fluid" src="{{ asset('logo.png') }}" alt="Login">
      </div>
      <div class="col-lg-4 offset-lg-1">
        <p>Sign in to your seller account.</p>
          <form action="{{ route('login') }}" method="post">
            @csrf
              <div class="form-group mb-4">
                  <input type="text" class="form-control form-control-lg" autofocus="" placeholder="Email" name="email">
                  @if($errors->has('email'))
              <span class="help-text">{{ collect($errors->get('email'))->first() }}</span>
              @endif
              </div>
              <div class="form-group mb-4">
                  <input type="password" class="form-control form-control-lg" placeholder="Password" name="password">
              </div>
              <button class="btn btn-primary btn-lg btn-block btn-uppercase mb-4">Sign In</button>
              <div class="d-flex justify-content-between align-items-center mb-4">
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="remember-me" name="remember" value="1">
                      <label class="custom-control-label" for="remember-me">Keep me signed in</label>
                  </div>
                  <a href="{{ route('forgot-password') }}" class="auth-link text-black">Forgot password?</a>
              </div>
          </form>
      </div>
  </div>
</div>
@endsection