<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="icon" href="{{ asset('atlantis-assets/img/icon1.png') }}" type="image/x-icon"/>
    @include('scripts.baseStyles')
    @yield('contentStyles')
</head>
<body>
	<div class="wrapper">
		<div class="main-header">
			<x-header></x-header>
			<x-navbar></x-navbar>
        </div>
        <x-sidebar></x-sidebar>
        <div class="main-panel">
            @yield('content')
            <x-footer></x-footer>
        </div>
	</div>
    @include('scripts.baseScripts')
    @yield('contentScripts')
</body>
</html>
