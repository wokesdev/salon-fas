@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title"></h4>
            </div>
            <div class="page-category">{{ Auth::user()->role->level }}</div>
        </div>
    </div>
    <x-footer></x-footer>
</div>
@endsection
