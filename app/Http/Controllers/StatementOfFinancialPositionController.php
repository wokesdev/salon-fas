<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountDetail;
use App\Models\GeneralEntry;
use App\Models\GeneralEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class StatementOfFinancialPositionController extends Controller
{
    public function index(Request $request)
    {
        // $whereIsAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
        // $whereIsKewajiban = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->pluck('id')->toArray();
        // $whereIsModal = Account::where('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();

        // $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        // $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

        // $whereIsAktivaKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsAktiva)->orWhereIn('account_id', $whereIsKewajiban)->orWhereIn('account_id', $whereIsModal)->orWhereIn('account_id', $whereIsPendapatan)->orWhereIn('account_id', $whereIsBeban)->pluck('id')->toArray();

        // if ($request->ajax()) {
        //     if(!empty($request->from_date))
        //     {
        //         if ($request->from_date === $request->to_date) {
        //             $from_date = $request->from_date;
        //             $to_date = $request->from_date;

        //             $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit) as sumDebit'), DB::raw('SUM(kredit) as sumKredit'))
        //                 ->whereIn('account_detail_id', $whereIsAktivaKewajibanModalDetail)
        //                 ->with(['account_detail', 'general_entry'])
        //                 ->whereHas('general_entry', function ($query) use($from_date) {
        //                     return $query->whereDate('tanggal', '=', $from_date);
        //                 })
        //                 ->groupBy('account_detail_id')
        //                 ->get();
        //         }

        //         else {
        //             $from_date = $request->from_date;
        //             $to_date = $request->to_date;

        //             $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit) as sumDebit'), DB::raw('SUM(kredit) as sumKredit'))
        //                 ->whereIn('account_detail_id', $whereIsAktivaKewajibanModalDetail)
        //                 ->with(['account_detail', 'general_entry'])
        //                 ->whereHas('general_entry', function ($query) use($from_date, $to_date) {
        //                     return $query->whereBetween('general_entries.tanggal', array($from_date, $to_date));
        //                 })
        //                 ->groupBy('account_detail_id')
        //                 ->get();
        //         }
        //     }

        //     else {
        //         $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit) as sumDebit'), DB::raw('SUM(kredit) as sumKredit'))
        //             ->whereIn('account_detail_id', $whereIsAktivaKewajibanModalDetail)
        //             ->with(['account_detail', 'general_entry'])
        //             ->groupBy('account_detail_id')
        //             ->get();
        //     }

        //     return DataTables::of($generalEntryDetails)
        //         ->editColumn('altered_jenis_aktiva', function ($generalEntryDetails) {
        //             $whereIsAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
        //             $whereIsAktivaDetail = AccountDetail::whereIn('account_id', $whereIsAktiva)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsAktivaDetail)) {
        //                 return $generalEntryDetails->account_detail->account->nama_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         ->editColumn('altered_aktiva', function ($generalEntryDetails) {
        //             $whereIsAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
        //             $whereIsAktivaDetail = AccountDetail::whereIn('account_id', $whereIsAktiva)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsAktivaDetail)) {
        //                 return $generalEntryDetails->account_detail->nama_rincian_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         ->editColumn('altered_nominal_aktiva', function ($generalEntryDetails) {
        //             $whereisAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
        //             $whereisAktivaDetail = AccountDetail::whereIn('account_id', $whereisAktiva)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereisAktivaDetail)) {
        //                 $sumAktiva = $generalEntryDetails->sumDebit - $generalEntryDetails->sumKredit;
        //                 return $sumAktiva;
        //             } else {
        //                 return 0;
        //             }
        //         })
        //         ->editColumn('altered_jenis_kewajiban_modal', function ($generalEntryDetails) {
        //             $whereIsKewajibanModal = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->orWhere('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
        //             $whereIsKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsKewajibanModal)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsKewajibanModalDetail)) {
        //                 return $generalEntryDetails->account_detail->account->nama_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         ->editColumn('altered_kewajiban_modal', function ($generalEntryDetails) {
        //             $whereIsKewajibanModal = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->orWhere('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
        //             $whereIsKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsKewajibanModal)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsKewajibanModalDetail)) {
        //                 return $generalEntryDetails->account_detail->nama_rincian_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         // ->editColumn('altered_nominal_kewajiban_modal', function ($generalEntryDetails) {
        //         //     if ($generalEntryDetails->sumDebitKredit > 0) {
        //         //         return $generalEntryDetails->sumDebitKredit;
        //         //     } else if ($generalEntryDetails->sumDebitKredit < 0) {
        //         //         return -($generalEntryDetails->sumDebitKredit);
        //         //     } else {
        //         //         return null;
        //         //     }
        //         // })
        //         ->editColumn('altered_nominal_kewajiban_modal', function ($generalEntryDetails) {
        //             $whereIsKewajibanModal = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->orWhere('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
        //             $whereIsKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsKewajibanModal)->pluck('id')->toArray();

        //             $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //             $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

        //             $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
        //             $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();
        //             $sumPendapatan = GeneralEntryDetail::select('id')->whereIn('account_detail_id', $whereIsPendapatanDetail)->sum('kredit');
        //             $sumBeban = GeneralEntryDetail::select('id')->whereIn('account_detail_id', $whereIsBebanDetail)->sum('debit');
        //             $labaBersih = $sumPendapatan - $sumBeban;

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsKewajibanModalDetail)) {
        //                 $sumPasiva = $generalEntryDetails->sumKredit - $generalEntryDetails->sumDebit;
        //                 return $sumPasiva;
        //             } else {
        //                 return 0;
        //             }
        //         })
        //         ->editColumn('altered_pendapatan', function ($generalEntryDetails) {
        //             $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //             $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsPendapatanDetail)) {
        //                 return $generalEntryDetails->account_detail->nama_rincian_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         ->editColumn('altered_nominal_pendapatan', function ($generalEntryDetails) {
        //             $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //             $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsPendapatanDetail)) {
        //                 return $generalEntryDetails->account_detail->nama_rincian_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         ->editColumn('altered_beban', function ($generalEntryDetails) {
        //             $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
        //             $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsBebanDetail)) {
        //                 return $generalEntryDetails->account_detail->nama_rincian_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         // ->editColumn('altered_nominal_laba_bersih', function ($generalEntryDetails) use ($from_date, $to_date) {
        //         //     $whereisAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
        //         //     $whereisAktivaDetail = AccountDetail::whereIn('account_id', $whereisAktiva)->pluck('id')->toArray();

        //         //     $whereIsKewajibanModal = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->orWhere('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
        //         //     $whereIsKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsKewajibanModal)->pluck('id')->toArray();

        //         //     $generalEntryDetails2 = GeneralEntryDetail::select('id')->whereIn('account_detail_id', $whereisAktivaDetail)->orWhereIn('account_detail_id', $whereIsKewajibanModalDetail)->first();
        //         //     if(!empty($from_date)) {
        //         //         if ($from_date === $to_date) {
        //         //             $from_date = $from_date;

        //         //             $currentFromDate = GeneralEntry::whereDate('tanggal', $from_date)->pluck('id')->toArray();

        //         //             $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //         //             $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

        //         //             $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
        //         //             $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();
        //         //             $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
        //         //             $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
        //         //             $labaBersih = $sumPendapatan - $sumBeban;
        //         //         }

        //         //         else if ($from_date !== $to_date) {
        //         //             $from_date = $from_date;
        //         //             $to_date = $to_date;

        //         //             $currentFromDate = GeneralEntry::whereBetween('tanggal', array($from_date, $to_date))->pluck('id')->toArray();

        //         //             $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //         //             $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

        //         //             $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
        //         //             $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();
        //         //             $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
        //         //             $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
        //         //             $labaBersih = $sumPendapatan - $sumBeban;
        //         //         }
        //         //     } else {
        //         //         $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //         //         $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

        //         //         $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
        //         //         $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();
        //         //         $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->sum('kredit');
        //         //         $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->sum('debit');
        //         //         $labaBersih = $sumPendapatan - $sumBeban;
        //         //     }

        //         //     if ($generalEntryDetails->id == $generalEntryDetails2->id) {
        //         //         return $labaBersih;
        //         //     } else {
        //         //         return 0;
        //         //     }

        //         // })
        //         // ->editColumn('altered_beban', function ($generalEntryDetails) {
        //         //     $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
        //         //     $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

        //         //     if (in_array($generalEntryDetails->account_detail_id, $whereIsBebanDetail)) {
        //         //         return $generalEntryDetails->account_detail->nama_rincian_akun;
        //         //     } else {
        //         //         return '-';
        //         //     }
        //         // })
        //         // ->editColumn('altered_nominal_beban', function ($generalEntryDetails) {
        //         //     $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
        //         //     $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

        //         //     if (in_array($generalEntryDetails->account_detail_id, $whereIsBebanDetail)) {
        //         //         if (!empty($generalEntryDetails->purchase_id)) {
        //         //             return $generalEntryDetails->purchase->total;
        //         //         } else if (!empty($generalEntryDetails->sale_id)) {
        //         //             return $generalEntryDetails->sale->total;
        //         //         } else if (!empty($generalEntryDetails->cash_payment_id)) {
        //         //             return $generalEntryDetails->cash_payment->jumlah;
        //         //         } else if (!empty($generalEntryDetails->cash_receipt_id)) {
        //         //             return $generalEntryDetails->cash_receipt->jumlah;
        //         //         } else {
        //         //             return null;
        //         //         }
        //         //     } else {
        //         //         return 0;
        //         //     }
        //         // })
        //         ->make(true);
        // }
        // return view('laporan.laporan-posisi-keuangan.index');

        return view('laporan.laporan-posisi-keuangan.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
                if ($request->from_date === $request->to_date) {
                    $from_date = $request->from_date;
                    $to_date = $request->from_date;

                    $currentFromDate = GeneralEntry::whereDate('tanggal', $from_date)->pluck('id')->toArray();

                    $whereIsAktivaLancar = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Lancar')->first();
                    $whereIsAktivaTetap = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Tetap')->first();
                    $whereIsKewajiban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Liabilitas Jangka')->first();
                    $whereIsPermodalan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Ekuitas')->first();

                    $whereIsAktivaLancarDetail = AccountDetail::where('account_id', $whereIsAktivaLancar->id)->pluck('id')->toArray();
                    $whereIsAktivaTetapDetail = AccountDetail::where('account_id', $whereIsAktivaTetap->id)->pluck('id')->toArray();
                    $whereIsKewajibanDetail = AccountDetail::where('account_id', $whereIsKewajiban->id)->pluck('id')->toArray();
                    $whereIsPermodalanDetail = AccountDetail::where('account_id', $whereIsPermodalan->id)->pluck('id')->toArray();

                    $aktivaLancarGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $aktivaTetapGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $kewajibanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $permodalanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                    $sumDebitAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $sumDebitAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $sumDebitKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $sumDebitPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
                    $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

                    $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                    $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                    $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                    $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                    $labaBersih = $sumPendapatan - $sumBeban;

                    $sumAktivaLancar = $sumDebitAktivaLancar - $sumKreditAktivaLancar;
                    $sumAktivaTetap = $sumDebitAktivaTetap - $sumKreditAktivaTetap;
                    $sumKewajiban = $sumKreditKewajiban - $sumDebitKewajiban;
                    $sumPermodalan = ($sumKreditPermodalan - $sumDebitPermodalan) + $labaBersih;

                    $sumAktiva = $sumAktivaLancar + $sumAktivaTetap;
                    $sumPasiva = $sumKewajiban + $sumPermodalan;

                    //Aktiva Lancar
                    $response = '<tr>';
                        $response .= '<td>' . $whereIsAktivaLancar->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsAktivaLancar->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($aktivaLancarGeneralEntryDetails as $aktivaLancarGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $aktivaLancarGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $aktivaLancarGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit') - GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumAktivaLancar, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    //Aktiva Tetap
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsAktivaTetap->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsAktivaTetap->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($aktivaTetapGeneralEntryDetails as $aktivaTetapGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $aktivaTetapGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $aktivaTetapGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit') - GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumAktivaTetap, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td><b>Total Aktiva</b></td>';
                        $response .= '<td><b>Rp' . number_format($sumAktiva, 0, '' , '.') . ',-</b></td>';
                    $response .= '</tr>';

                    //Kewajiban
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsKewajiban->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsKewajiban->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($kewajibanGeneralEntryDetails as $kewajibanGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $kewajibanGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $kewajibanGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit') - GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumKewajiban, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    //Permodalan
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsPermodalan->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsPermodalan->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($permodalanGeneralEntryDetails as $permodalanGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $permodalanGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $permodalanGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit') - GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>-</td>';
                        $response .= '<td>Laba Bersih</td>';
                        $response .= '<td>Rp'. number_format($labaBersih, 0, '' , '.') .',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumPermodalan, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td><b>Total Pasiva</b></td>';
                        $response .= '<td><b>Rp' . number_format($sumPasiva, 0, '' , '.') . ',-</b></td>';
                    $response .= '</tr>';

                    echo $response;
                }

                else {
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;

                    $currentFromDate = GeneralEntry::whereBetween('tanggal', array($from_date, $to_date))->pluck('id')->toArray();

                    $whereIsAktivaLancar = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Lancar')->first();
                    $whereIsAktivaTetap = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Tetap')->first();
                    $whereIsKewajiban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Liabilitas Jangka')->first();
                    $whereIsPermodalan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Ekuitas')->first();

                    $whereIsAktivaLancarDetail = AccountDetail::where('account_id', $whereIsAktivaLancar->id)->pluck('id')->toArray();
                    $whereIsAktivaTetapDetail = AccountDetail::where('account_id', $whereIsAktivaTetap->id)->pluck('id')->toArray();
                    $whereIsKewajibanDetail = AccountDetail::where('account_id', $whereIsKewajiban->id)->pluck('id')->toArray();
                    $whereIsPermodalanDetail = AccountDetail::where('account_id', $whereIsPermodalan->id)->pluck('id')->toArray();

                    $aktivaLancarGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $aktivaTetapGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $kewajibanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $permodalanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                    $sumDebitAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $sumDebitAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $sumDebitKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $sumDebitPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                    $sumKreditPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                    $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
                    $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

                    $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                    $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                    $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                    $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                    $labaBersih = $sumPendapatan - $sumBeban;

                    $sumAktivaLancar = $sumDebitAktivaLancar - $sumKreditAktivaLancar;
                    $sumAktivaTetap = $sumDebitAktivaTetap - $sumKreditAktivaTetap;
                    $sumKewajiban = $sumKreditKewajiban - $sumDebitKewajiban;
                    $sumPermodalan = ($sumKreditPermodalan - $sumDebitPermodalan) + $labaBersih;

                    $sumAktiva = $sumAktivaLancar + $sumAktivaTetap;
                    $sumPasiva = $sumKewajiban + $sumPermodalan;

                    //Aktiva Lancar
                    $response = '<tr>';
                        $response .= '<td>' . $whereIsAktivaLancar->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsAktivaLancar->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($aktivaLancarGeneralEntryDetails as $aktivaLancarGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $aktivaLancarGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $aktivaLancarGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit') - GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumAktivaLancar, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    //Aktiva Tetap
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsAktivaTetap->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsAktivaTetap->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($aktivaTetapGeneralEntryDetails as $aktivaTetapGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $aktivaTetapGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $aktivaTetapGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit') - GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumAktivaTetap, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td><b>Total Aktiva</b></td>';
                        $response .= '<td><b>Rp' . number_format($sumAktiva, 0, '' , '.') . ',-</b></td>';
                    $response .= '</tr>';

                    //Kewajiban
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsKewajiban->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsKewajiban->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($kewajibanGeneralEntryDetails as $kewajibanGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $kewajibanGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $kewajibanGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit') - GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumKewajiban, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    //Permodalan
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsPermodalan->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsPermodalan->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($permodalanGeneralEntryDetails as $permodalanGeneralEntryDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $permodalanGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $permodalanGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit') - GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>-</td>';
                        $response .= '<td>Laba Bersih</td>';
                        $response .= '<td>Rp'. number_format($labaBersih, 0, '' , '.') .',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumPermodalan, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td><b>Total Pasiva</b></td>';
                        $response .= '<td><b>Rp' . number_format($sumPasiva, 0, '' , '.') . ',-</b></td>';
                    $response .= '</tr>';

                    echo $response;
                }
            }

            else {
                $from_date = null;
                $to_date = null;

                $whereIsAktivaLancar = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Lancar')->first();
                $whereIsAktivaTetap = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Tetap')->first();
                $whereIsKewajiban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Liabilitas Jangka')->first();
                $whereIsPermodalan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Ekuitas')->first();

                $whereIsAktivaLancarDetail = AccountDetail::where('account_id', $whereIsAktivaLancar->id)->pluck('id')->toArray();
                $whereIsAktivaTetapDetail = AccountDetail::where('account_id', $whereIsAktivaTetap->id)->pluck('id')->toArray();
                $whereIsKewajibanDetail = AccountDetail::where('account_id', $whereIsKewajiban->id)->pluck('id')->toArray();
                $whereIsPermodalanDetail = AccountDetail::where('account_id', $whereIsPermodalan->id)->pluck('id')->toArray();

                $aktivaLancarGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $aktivaTetapGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $kewajibanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $permodalanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                $sumDebitAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->sum('debit');
                $sumKreditAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->sum('kredit');

                $sumDebitAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->sum('debit');
                $sumKreditAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->sum('kredit');

                $sumDebitKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->sum('debit');
                $sumKreditKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->sum('kredit');

                $sumDebitPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->sum('debit');
                $sumKreditPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->sum('kredit');

                $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
                $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

                $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->sum('kredit');
                $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->sum('debit');

                $labaBersih = $sumPendapatan - $sumBeban;

                $sumAktivaLancar = $sumDebitAktivaLancar - $sumKreditAktivaLancar;
                $sumAktivaTetap = $sumDebitAktivaTetap - $sumKreditAktivaTetap;
                $sumKewajiban = $sumKreditKewajiban - $sumDebitKewajiban;
                $sumPermodalan = ($sumKreditPermodalan - $sumDebitPermodalan) + $labaBersih;

                $sumAktiva = $sumAktivaLancar + $sumAktivaTetap;
                $sumPasiva = $sumKewajiban + $sumPermodalan;

                //Aktiva Lancar
                $response = '<tr>';
                    $response .= '<td>' . $whereIsAktivaLancar->nomor_akun . '</td>';
                    $response .= '<td>' . $whereIsAktivaLancar->nama_akun . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                $response .= '</tr>';

                foreach ($aktivaLancarGeneralEntryDetails as $aktivaLancarGeneralEntryDetail) {
                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>' . $aktivaLancarGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                        $response .= '<td>' . $aktivaLancarGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                        $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->sum('debit') - GeneralEntryDetail::where('account_detail_id', $aktivaLancarGeneralEntryDetail->account_detail_id)->sum('kredit'), 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';
                }

                $response .= '<tr>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3">Total</td>';
                    $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumAktivaLancar, 0, '' , '.') . ',-</td>';
                $response .= '</tr>';

                //Aktiva Tetap
                $response .= '<tr>';
                    $response .= '<td>' . $whereIsAktivaTetap->nomor_akun . '</td>';
                    $response .= '<td>' . $whereIsAktivaTetap->nama_akun . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                $response .= '</tr>';

                foreach ($aktivaTetapGeneralEntryDetails as $aktivaTetapGeneralEntryDetail) {
                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>' . $aktivaTetapGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                        $response .= '<td>' . $aktivaTetapGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                        $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->sum('debit') - GeneralEntryDetail::where('account_detail_id', $aktivaTetapGeneralEntryDetail->account_detail_id)->sum('kredit'), 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';
                }

                $response .= '<tr>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3">Total</td>';
                    $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumAktivaTetap, 0, '' , '.') . ',-</td>';
                $response .= '</tr>';

                $response .= '<tr>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td><b>Total Aktiva</b></td>';
                    $response .= '<td><b>Rp' . number_format($sumAktiva, 0, '' , '.') . ',-</b></td>';
                $response .= '</tr>';

                //Kewajiban
                $response .= '<tr>';
                    $response .= '<td>' . $whereIsKewajiban->nomor_akun . '</td>';
                    $response .= '<td>' . $whereIsKewajiban->nama_akun . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                $response .= '</tr>';

                foreach ($kewajibanGeneralEntryDetails as $kewajibanGeneralEntryDetail) {
                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>' . $kewajibanGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                        $response .= '<td>' . $kewajibanGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                        $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->sum('kredit') - GeneralEntryDetail::where('account_detail_id', $kewajibanGeneralEntryDetail->account_detail_id)->sum('debit'), 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';
                }

                $response .= '<tr>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3">Total</td>';
                    $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumKewajiban, 0, '' , '.') . ',-</td>';
                $response .= '</tr>';

                //Permodalan
                $response .= '<tr>';
                    $response .= '<td>' . $whereIsPermodalan->nomor_akun . '</td>';
                    $response .= '<td>' . $whereIsPermodalan->nama_akun . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                $response .= '</tr>';

                foreach ($permodalanGeneralEntryDetails as $permodalanGeneralEntryDetail) {
                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>' . $permodalanGeneralEntryDetail->account_detail->nomor_rincian_akun . '</td>';
                        $response .= '<td>' . $permodalanGeneralEntryDetail->account_detail->nama_rincian_akun . '</td>';
                        $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->sum('kredit') - GeneralEntryDetail::where('account_detail_id', $permodalanGeneralEntryDetail->account_detail_id)->sum('debit'), 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';
                }

                $response .= '<tr>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td>-</td>';
                    $response .= '<td>Laba Bersih</td>';
                    $response .= '<td>Rp'. number_format($labaBersih, 0, '' , '.') .',-</td>';
                $response .= '</tr>';

                $response .= '<tr>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3">Total</td>';
                    $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumPermodalan, 0, '' , '.') . ',-</td>';
                $response .= '</tr>';

                $response .= '<tr>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td><b>Total Pasiva</b></td>';
                    $response .= '<td><b>Rp' . number_format($sumPasiva, 0, '' , '.') . ',-</b></td>';
                $response .= '</tr>';

                echo $response;
            }
        }
    }

    public function makePDF(Request $request)
    {
        if(!empty($request->from_date_pdf))
        {
            if ($request->from_date_pdf === $request->to_date_pdf) {
                $from_date_pdf = $request->from_date_pdf;
                $to_date_pdf = $request->from_date_pdf;

                $currentFromDate = GeneralEntry::whereDate('tanggal', $from_date_pdf)->pluck('id')->toArray();

                $whereIsAktivaLancar = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Lancar')->first();
                $whereIsAktivaTetap = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Tetap')->first();
                $whereIsKewajiban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Liabilitas Jangka')->first();
                $whereIsPermodalan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Ekuitas')->first();

                $whereIsAktivaLancarDetail = AccountDetail::where('account_id', $whereIsAktivaLancar->id)->pluck('id')->toArray();
                $whereIsAktivaTetapDetail = AccountDetail::where('account_id', $whereIsAktivaTetap->id)->pluck('id')->toArray();
                $whereIsKewajibanDetail = AccountDetail::where('account_id', $whereIsKewajiban->id)->pluck('id')->toArray();
                $whereIsPermodalanDetail = AccountDetail::where('account_id', $whereIsPermodalan->id)->pluck('id')->toArray();

                $aktivaLancarGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $aktivaTetapGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $kewajibanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $permodalanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                $sumDebitAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $sumDebitAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $sumDebitKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $sumDebitPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
                $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

                $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                $labaBersih = $sumPendapatan - $sumBeban;

                $sumAktivaLancar = $sumDebitAktivaLancar - $sumKreditAktivaLancar;
                $sumAktivaTetap = $sumDebitAktivaTetap - $sumKreditAktivaTetap;
                $sumKewajiban = $sumKreditKewajiban - $sumDebitKewajiban;
                $sumPermodalan = ($sumKreditPermodalan - $sumDebitPermodalan) + $labaBersih;

                $sumAktiva = $sumAktivaLancar + $sumAktivaTetap;
                $sumPasiva = $sumKewajiban + $sumPermodalan;
            }

            else {
                $from_date_pdf = $request->from_date_pdf;
                $to_date_pdf = $request->to_date_pdf;

                $currentFromDate = GeneralEntry::whereBetween('tanggal', array($from_date_pdf, $to_date_pdf))->pluck('id')->toArray();

                $whereIsAktivaLancar = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Lancar')->first();
                $whereIsAktivaTetap = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Tetap')->first();
                $whereIsKewajiban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Liabilitas Jangka')->first();
                $whereIsPermodalan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Ekuitas')->first();

                $whereIsAktivaLancarDetail = AccountDetail::where('account_id', $whereIsAktivaLancar->id)->pluck('id')->toArray();
                $whereIsAktivaTetapDetail = AccountDetail::where('account_id', $whereIsAktivaTetap->id)->pluck('id')->toArray();
                $whereIsKewajibanDetail = AccountDetail::where('account_id', $whereIsKewajiban->id)->pluck('id')->toArray();
                $whereIsPermodalanDetail = AccountDetail::where('account_id', $whereIsPermodalan->id)->pluck('id')->toArray();

                $aktivaLancarGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $aktivaTetapGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $kewajibanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $permodalanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                $sumDebitAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $sumDebitAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $sumDebitKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $sumDebitPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');
                $sumKreditPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');

                $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
                $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

                $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                $labaBersih = $sumPendapatan - $sumBeban;

                $sumAktivaLancar = $sumDebitAktivaLancar - $sumKreditAktivaLancar;
                $sumAktivaTetap = $sumDebitAktivaTetap - $sumKreditAktivaTetap;
                $sumKewajiban = $sumKreditKewajiban - $sumDebitKewajiban;
                $sumPermodalan = ($sumKreditPermodalan - $sumDebitPermodalan) + $labaBersih;

                $sumAktiva = $sumAktivaLancar + $sumAktivaTetap;
                $sumPasiva = $sumKewajiban + $sumPermodalan;
            }
        }

        else {
            $from_date_pdf = null;
            $to_date_pdf = null;

            $currentFromDate = GeneralEntry::pluck('id')->toArray();

            $whereIsAktivaLancar = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Lancar')->first();
            $whereIsAktivaTetap = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Aktiva Tetap')->first();
            $whereIsKewajiban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Liabilitas Jangka')->first();
            $whereIsPermodalan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Ekuitas')->first();

            $whereIsAktivaLancarDetail = AccountDetail::where('account_id', $whereIsAktivaLancar->id)->pluck('id')->toArray();
            $whereIsAktivaTetapDetail = AccountDetail::where('account_id', $whereIsAktivaTetap->id)->pluck('id')->toArray();
            $whereIsKewajibanDetail = AccountDetail::where('account_id', $whereIsKewajiban->id)->pluck('id')->toArray();
            $whereIsPermodalanDetail = AccountDetail::where('account_id', $whereIsPermodalan->id)->pluck('id')->toArray();

            $aktivaLancarGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
            $aktivaTetapGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
            $kewajibanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
            $permodalanGeneralEntryDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

            $sumDebitAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->sum('debit');
            $sumKreditAktivaLancar = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaLancarDetail)->sum('kredit');

            $sumDebitAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->sum('debit');
            $sumKreditAktivaTetap = GeneralEntryDetail::whereIn('account_detail_id', $whereIsAktivaTetapDetail)->sum('kredit');

            $sumDebitKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->sum('debit');
            $sumKreditKewajiban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsKewajibanDetail)->sum('kredit');

            $sumDebitPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->sum('debit');
            $sumKreditPermodalan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPermodalanDetail)->sum('kredit');

            $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
            $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();

            $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
            $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

            $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->sum('kredit');
            $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->sum('debit');

            $labaBersih = $sumPendapatan - $sumBeban;

            $sumAktivaLancar = $sumDebitAktivaLancar - $sumKreditAktivaLancar;
            $sumAktivaTetap = $sumDebitAktivaTetap - $sumKreditAktivaTetap;
            $sumKewajiban = $sumKreditKewajiban - $sumDebitKewajiban;
            $sumPermodalan = ($sumKreditPermodalan - $sumDebitPermodalan) + $labaBersih;

            $sumAktiva = $sumAktivaLancar + $sumAktivaTetap;
            $sumPasiva = $sumKewajiban + $sumPermodalan;
        }

        $pdf = PDF::loadView('pdf.laporan-posisi-keuangan.index', compact(
            'whereIsAktivaLancar',
            'whereIsAktivaTetap',
            'whereIsKewajiban',
            'whereIsPermodalan',
            'aktivaLancarGeneralEntryDetails',
            'aktivaTetapGeneralEntryDetails',
            'kewajibanGeneralEntryDetails',
            'permodalanGeneralEntryDetails',
            'labaBersih',
            'sumAktivaLancar',
            'sumAktivaTetap',
            'sumKewajiban',
            'sumPermodalan',
            'sumAktiva',
            'sumPasiva',
            'currentFromDate'
        ));
        return $pdf->download('Laporan Posisi Keuangan - Salon Fas.pdf');
    }
}
