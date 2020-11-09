<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('atlantis-assets/img/icon1.png') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('self-assets/my-login.css') }}">
    <link rel="stylesheet" href="{{ asset('atlantis-assets/css/bootstrap.min.css') }}">
</head>
<body class="my-login-page">
    @yield('content')
    @include('scripts.baseScripts')
</body>
</html>
