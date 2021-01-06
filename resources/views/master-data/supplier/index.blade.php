@extends('layouts.app')
@section('title', 'Data Supplier')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Supplier</h4>
                            <button type="button" class="btn btn-primary btn-round ml-auto text-white" id="addButton" data-toggle="modal" data-target="#addEditModal"><i class="fa fa-plus"></i> Tambah Supplier</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>Nama</th>
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
@include('master-data.supplier.createModal')
@endsection
@section('contentScripts')
    @include('master-data.supplier.scripts')
@endsection
