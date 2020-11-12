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
                        <form method="POST" action=""{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Alamat Email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
                                @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                            <div class="form-group m-0"><button type="submit" class="btn btn-primary btn-block" tabindex="4">Kirim Link Ganti Password</button></div>
                            <div class="mt-4 text-center"><a href="{{ route('login') }}">Kembali ke Login?</a></div>
                        </form>
                    </div>
                </div>
                <div class="footer">Copyright &copy; {{ date("Y") }} &mdash; Salon Fas</div>
            </div>
        </div>
    </div>
</section>
@endsection
