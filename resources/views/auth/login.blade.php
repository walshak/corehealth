@extends('layouts.login')

@section('content')

<div class="login-box">

    <div class="login-logo">
      <a href="{{ route('home') }}"><em>{{ $app->site_name }}</em></a>
    </div>

    <div class="card">
      {{-- <div class="card-header">{{ __('Login') }}</div> --}}
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in</p>

        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                <div class="input-group-append">
                    <span class="fa fa-envelope input-group-text"></span>
                </div>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="input-group mb-3">
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>
                <div class="input-group-append">
                    <span class="fa fa-lock input-group-text"></span>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-8">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>
                  </div>
                </div>

                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>

            </div>
        </form>

        {{-- <div class="social-auth-links text-center mb-3">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fa fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fa fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div> --}}
        <!-- /.social-auth-links -->

        <p class="mb-1">
            <a class="text-center" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        </p>
        <p class="mb-0">
            {{--  <a href="{{ route('register') }}" class="text-center">{{ __('Register') }}</a>  --}}
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>

</div>

@endsection
