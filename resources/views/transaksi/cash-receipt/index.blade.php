@extends('layouts.app')
@section('title', 'Penerimaan Kas')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Penerimaan Kas</h4>
                            <button type="button" class="btn btn-primary btn-round ml-auto text-white" id="addButton" data-toggle="modal" data-target="#addEditModal"><i class="fa fa-plus"></i> Tambah Penerimaan Kas</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor Nota</th>
                                        <th>Nomor Rincian Akun</th>
                                        <th>Nama Rincian Akun</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
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
@include('transaksi.cash-receipt.createModal')
@endsection
@section('contentScripts')
    @include('transaksi.cash-receipt.scripts')
@endsection
