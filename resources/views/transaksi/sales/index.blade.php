@extends('layouts.app')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Penjualan</h4>
                            <button type="button" class="btn btn-primary btn-round ml-auto text-white" id="addButton" data-toggle="modal" data-target="#addEditModal"><i class="fa fa-plus"></i> Tambah Pembelian</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor Penjualan</th>
                                        <th>Kode Pelanggan</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Nomor Rincian Akun</th>
                                        <th>Nama Rincian Akun</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
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
@include('transaksi.sales.createModal')
@include('transaksi.sales.showModal')
@endsection
@section('contentScripts')
    @include('transaksi.sales.scripts')
@endsection
