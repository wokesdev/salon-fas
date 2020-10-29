@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Reset Password</div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}" id="resetPassForm">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="form-group">
                            <label for="email" class="text-white">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control input-solid @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Email Address" name="email" value="{{ $request->email ?? old('email') }}" required autocomplete="email" readonly>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-white">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="text-white">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-primary pull-left" form="resetPassForm">{{ __('Reset Password') }}</button>
                    <a class="btn btn-link pull-right" href="{{ route('login') }}">
                        {{ __('Login?') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
