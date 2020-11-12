@extends('layouts.guest')
@section('content')
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand"><img src="{{ asset('atlantis-assets/img/logo-v2.png') }}" alt="logo"></div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Ganti Password</h4>
                        @if (session('status')) <div class="alert alert-success" role="alert">{{ session('status') }}</div> @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Alamat Email" name="email" value="{{ $request->email ?? old('email') }}" autocomplete="email" required readonly>
                                @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" autocomplete="new-password" autofocus required>
                                @error('password') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password-confirm" placeholder="Ulangi Password" name="password_confirmation" autocomplete="new-password" required>
                            </div>
                            <div class="form-group m-0"><button type="submit" class="btn btn-primary btn-block">Ganti Password</button></div>
                        </form>
                    </div>
                </div>
                <div class="footer">Copyright &copy; {{ date("Y") }} &mdash; Salon Fas</div>
            </div>
        </div>
    </div>
</section>
@endsection
