@extends('layouts.guest')
@section('content')
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand"><img src="{{ asset('atlantis-assets/img/logo-v2.png') }}" alt="logo"></div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Verifikasi Alamat Email Anda</h4>
                        @if (session('resent')) <div class="alert alert-success" role="alert">{{ session('resent') }}</div> @endif
                        Untuk menyelesaikan pendaftaran, mohon klik link yang dikirimkan ke alamat email Anda.
                        Kalau Anda tidak menerima email dari kami,
                        <form class="d-inline" method="POST" action=""{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">klik di sini untuk mengirim ulang.</button>.
                        </form>
                    </div>
                </div>
                <div class="footer">Copyright &copy; {{ date("Y") }} &mdash; Salon Fas</div>
            </div>
        </div>
    </div>
</section>
@endsection
