@extends('layouts.app')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Admin</h4>
                                <button type="button" class="btn btn-primary btn-round ml-auto text-white" id="addButton" data-toggle="modal" data-target="#addEditModal">
                                    <i class="fa fa-plus"></i>
                                    Tambah Admin
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="usersTable" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Jabatan</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.users.createModal')
@include('admin.users.deleteModal')
@endsection

@section('contentScripts')
    @include('admin.users.usersScripts')
@endsection
