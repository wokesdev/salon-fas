<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('atlantis-assets/img/icon1.png') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('self-assets/my-login.css') }}">
    <link rel="stylesheet" href="{{ asset('atlantis-assets/css/bootstrap.min.css') }}">
</head>
<body class="my-login-page">
    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('atlantis-assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('atlantis-assets/js/core/bootstrap.min.js') }}"></script>
</body>
</html>
