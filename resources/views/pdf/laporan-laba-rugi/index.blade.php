<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Laba/Rugi - Salon Fas</title>
    @include('scripts.baseStyles')
</head>
<body>
    <div class="card-body">
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
                <tbody>
                    {{-- Pendapatan --}}
                    <tr>
                        <td>{{ $whereIsPendapatan->nomor_akun }}</td>
                        <td>{{ $whereIsPendapatan->nama_akun }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach ($whereIsPendapatanDetails as $whereIsPendapatanDetail) {
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $whereIsPendapatanDetail->account_detail->nomor_rincian_akun }}</td>
                            <td>{{ $whereIsPendapatanDetail->account_detail->nama_rincian_akun }}</td>
                            <td>Rp{{ number_format(\App\Models\GeneralEntryDetail::where('account_detail_id', $whereIsPendapatanDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') }},-</td>
                        </tr>
                    }
                    @endforeach

                    <tr>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3">Total</td>
                        <td style="background-color: #D3D3D3">Rp{{ number_format($sumPendapatan, 0, '' , '.') }},-</td>
                    </tr>

                    {{-- Beban --}}
                    <tr>
                        <td>{{ $whereIsBeban->nomor_akun }}</td>
                        <td>{{ $whereIsBeban->nama_akun }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach ($whereIsBebanDetails as $whereIsBebanDetail) {
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $whereIsBebanDetail->account_detail->nomor_rincian_akun }}</td>
                            <td>{{ $whereIsBebanDetail->account_detail->nama_rincian_akun }}</td>
                            <td>Rp{{ number_format(\App\Models\GeneralEntryDetail::where('account_detail_id', $whereIsBebanDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') }},-</td>
                        </tr>
                    }
                    @endforeach

                    <tr>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3">Total</td>
                        <td style="background-color: #D3D3D3">Rp{{ number_format($sumBeban, 0, '' , '.') }},-</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Laba Bersih</b></td>
                        <td><b>{{ $labaBersih }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('scripts.baseScripts')
</body>
</html>
