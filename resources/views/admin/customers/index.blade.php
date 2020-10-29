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
                                <h4 class="card-title">Data Pelanggan</h4>
                                <button type="button" class="btn btn-primary btn-round ml-auto text-white" id="addButton" data-toggle="modal" data-target="#addEditModal">
                                    <i class="fa fa-plus"></i>
                                    Tambah Pelanggan
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="customersTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>Nomor HP</th>
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

@include('admin.customers.createModal')
@include('admin.customers.deleteModal')
@endsection

@section('contentScripts')
    @include('admin.customers.customersScripts')
@endsection
