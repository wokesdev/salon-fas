@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Login</div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="form-group">
                            <label for="username">{{ __('Username') }}</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" aria-describedby="usernameHelp" placeholder="Username or Email Address" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="remember">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="form-check-sign">{{ __('Remember Me') }}</span>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-primary pull-left" form="loginForm">{{ __('Login') }}</button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link pull-right" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
