<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Posisi Keuangan - Salon Fas</title>
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
                    {{-- Aktiva Lancar --}}
                    <tr>
                        <td>{{ $whereIsAktivaLancar->nomor_akun }}</td>
                        <td>{{ $whereIsAktivaLancar->nama_akun }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach ($aktivaLancarGeneralEntryDetails as $aktivaLancarGeneralEntryDetail) {
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $aktivaLancarGeneralEntryDetail->account_detail->nomor_rincian_akun }}</td>
                            <td>{{ $aktivaLancarGeneralEntryDetail->account_detail->nama_rincian_akun }}</td>
                            <td>Rp{{ number_format(\App\Models\GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit') - \App\Models\GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') }},-</td>
                        </tr>
                    }
                    @endforeach

                    <tr>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3">Total</td>
                        <td style="background-color: #D3D3D3">Rp{{ number_format($sumAktivaLancar, 0, '' , '.') }},-</td>
                    </tr>

                    {{-- Aktiva Tetap --}}
                    <tr>
                        <td>{{ $whereIsAktivaTetap->nomor_akun }}</td>
                        <td>{{ $whereIsAktivaTetap->nama_akun }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach ($aktivaTetapGeneralEntryDetails as $aktivaTetapGeneralEntryDetail) {
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $aktivaTetapGeneralEntryDetail->account_detail->nomor_rincian_akun }}</td>
                            <td>{{ $aktivaTetapGeneralEntryDetail->account_detail->nama_rincian_akun }}</td>
                            <td>Rp{{ number_format(\App\Models\GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit') - \App\Models\GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') }},-</td>
                        </tr>
                    }
                    @endforeach

                    <tr>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3">Total</td>
                        <td style="background-color: #D3D3D3">Rp{{ number_format($sumAktivaTetap, 0, '' , '.') }},-</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total Aktiva</b></td>
                        <td><b>Rp{{ number_format($sumAktiva, 0, '' , '.') }},-</b></td>
                    </tr>

                    {{-- Kewajiban --}}
                    <tr>
                        <td>{{ $whereIsKewajiban->nomor_akun }}</td>
                        <td>{{ $whereIsKewajiban->nama_akun }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach ($kewajibanGeneralEntryDetails as $kewajibanGeneralEntryDetail) {
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $kewajibanGeneralEntryDetail->account_detail->nomor_rincian_akun }}</td>
                            <td>{{ $kewajibanGeneralEntryDetail->account_detail->nama_rincian_akun }}</td>
                            <td>Rp{{ number_format(\App\Models\GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit') - \App\Models\GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') }},-</td>
                        </tr>
                    }
                    @endforeach

                    <tr>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3">Total</td>
                        <td style="background-color: #D3D3D3">Rp{{ number_format($sumKewajiban, 0, '' , '.') }},-</td>
                    </tr>

                    {{-- Permodalan --}}
                    <tr>
                        <td>{{ $whereIsPermodalan->nomor_akun }}</td>
                        <td>{{ $whereIsPermodalan->nama_akun }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach ($permodalanGeneralEntryDetails as $permodalanGeneralEntryDetail) {
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $permodalanGeneralEntryDetail->account_detail->nomor_rincian_akun }}</td>
                            <td>{{ $permodalanGeneralEntryDetail->account_detail->nama_rincian_akun }}</td>
                            <td>Rp{{ number_format(\App\Models\GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit') - \App\Models\GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') }},-</td>
                        </tr>
                    }
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td>-</td>
                        <td>Laba Bersih</td>
                        <td>Rp{{ number_format($labaBersih, 0, '' , '.') }},-</td>
                    </tr>

                    <tr>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3"></td>
                        <td style="background-color: #D3D3D3">Total</td>
                        <td style="background-color: #D3D3D3">Rp{{ number_format($sumPermodalan, 0, '' , '.') }},-</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total Pasiva</b></td>
                        <td><b>Rp{{ number_format($sumPasiva, 0, '' , '.') }},-</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @include('scripts.baseScripts')
</body>
</html>
