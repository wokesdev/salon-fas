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
                    <form method="POST" action="{{ route('password.email') }}" id="forgotPassForm">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="text-white">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-primary pull-left" form="forgotPassForm">{{ __('Send Password Reset Link') }}</button>
                    <a class="btn btn-link pull-right" href="{{ route('login') }}">
                        {{ __('Login?') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
