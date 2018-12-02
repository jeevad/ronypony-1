@extends('admin.layouts.auth')

@section('content')
<section class="login-content">
    <div class="logo">
      <h1>Ronypony</h1>
    </div>
    <div class="login-box">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>{{ __('Login') }}</h3>
        <div class="form-group">
          <label class="control-label">{{ __('E-Mail Address') }}</label>
          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
        </div>
        <div class="form-group">
          <label class="control-label">{{ __('Password') }}</label>
          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
        </div>
        
        <div class="form-group">
          <div class="utility">
            <div class="animated-checkbox">
              <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="label-text" for="remember">{{ __('Remember Me') }}</span>
              </label>
            </div>
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a> --}}
          </div>
        </div>
        <div class="form-group btn-container">                
          <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>{{ __('Login') }}</button>
        </div>
      </form>
      {{-- <form class="forget-form" action="index.html">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
        <div class="form-group">
          <label class="control-label">EMAIL</label>
          <input class="form-control" type="text" placeholder="Email">
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
        </div>
      </form> --}}
    </div>
  </section>
@endsection
