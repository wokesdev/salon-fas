@extends('layouts.app')
@section('title', 'Laporan Pembelian')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Laporan Pembelian</h4>
                            <div class="row input-daterange ml-auto">
                                <div class="col-md-4">
                                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Dari Tanggal" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Hingga Tanggal" readonly>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                                    <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nomor Pembelian</th>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Keterangan</th>
                                        <th>Mata Uang</th>
                                        <th>Jumlah (IDR)</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>IDR</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentScripts')
    @include('laporan.laporan-pembelian.scripts')
@endsection
