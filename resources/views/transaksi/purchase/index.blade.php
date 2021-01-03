@extends('layouts.app')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Pembelian</h4>
                            <button type="button" class="btn btn-primary btn-round ml-auto" id="addButton" data-toggle="modal" data-target="#addEditModal"><i class="fa fa-plus"></i> Tambah Pembelian</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor Pembelian</th>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Nomor Rincian Akun</th>
                                        <th>Nama Rincian Akun</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
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
@include('transaksi.purchase.createModal')
@include('transaksi.purchase.showModal')
@include('transaksi.purchase.editDetailModal')
@endsection
@section('contentScripts')
    @include('transaksi.purchase.scripts')
@endsection
