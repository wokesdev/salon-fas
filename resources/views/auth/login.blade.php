@extends('layouts.guest')
@section('content')
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand"><img src="{{ asset('atlantis-assets/img/logo-v2.png') }}" alt="logo"></div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Login</h4>
                        @if (session('status')) <div class="alert alert-success" role="alert">{{ session('status') }}</div> @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username atau Alamat Email" name="username" value="{{ old('username') }}" autocomplete="username" tabindex="1" autofocus required>
                                @error('username') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                            <div class="form-group">
                                @if (Route::has('password.request')) <label for="password">Password<a href="{{ route('password.request') }}" class="float-right">Lupa Password?</a></label> @endif
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" autocomplete="current-password" tabindex="2" required>
                                @error('password') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                            <div class="form-group">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember" tabindex="3" {{ old('remember') !== null ? 'checked' : '' }}>
                                    <label for="remember" class="custom-control-label">Ingat Saya</label>
                                </div>
                            </div>
                            <div class="form-group m-0"><button type="submit" class="btn btn-primary btn-block" tabindex="4">Login</button></div>
                        </form>
                    </div>
                </div>
                <div class="footer">Copyright &copy; {{ date("Y") }} &mdash; Salon Fas</div>
            </div>
        </div>
    </div>
</section>
@endsection
