@extends('layouts.app')
@section('title', 'Laporan Laba/Rugi')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Laporan Laba/Rugi</h4>
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
                    </div>
                    <div class="card-body">
                        <div class="row ml-auto">
                            <div class="col-md-4">
                                <form action="{{ route('income-statement.makePdf') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="from_date_pdf" id="from_date_pdf">
                                    <input type="hidden" name="to_date_pdf" id="to_date_pdf">
                                    <button type="submit" name="makePDF" id="makePDF" class="btn btn-default">Export PDF</button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table" class="display table">
                                <thead>
                                    <tr>
                                        <th>Nomor Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Nomor Rincian Akun</th>
                                        <th>Nama Rincian Akun</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
    @include('laporan.laporan-laba-rugi.scripts')
@endsection
