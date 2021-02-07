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

class IncomeStatementController extends Controller
{
    public function index(Request $request)
    {
        // $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        // $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
        // $whereIsPendapatanBebanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->orWhere('account_id', $whereIsBeban->id)->pluck('id')->toArray();

        // if ($request->ajax()) {
        //     if(!empty($request->from_date))
        //     {
        //         if ($request->from_date === $request->to_date) {
        //             $from_date = $request->from_date;
        //             $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit) as sumDebit'), DB::raw('SUM(kredit) as sumKredit'))
        //                 ->whereIn('account_detail_id', $whereIsPendapatanBebanDetail)
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
        //                 ->whereIn('account_detail_id', $whereIsPendapatanBebanDetail)
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
        //             ->whereIn('account_detail_id', $whereIsPendapatanBebanDetail)
        //             ->with(['account_detail', 'general_entry'])
        //             ->groupBy('account_detail_id')
        //             ->get();
        //     }

        //     return DataTables::of($generalEntryDetails)
        //         ->editColumn('altered_pendapatan', function ($generalEntryDetails) {
        //             $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //             $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsPendapatanDetail)) {
        //                 return $generalEntryDetails->account_detail->nama_rincian_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
        //         // ->editColumn('altered_nominal_pendapatan', function ($generalEntryDetails) {
        //         //     $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        //         //     $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();

        //         //     if (in_array($generalEntryDetails->account_detail_id, $whereIsPendapatanDetail)) {
        //         //         if ($generalEntryDetails->sumDebit > 0) {
        //         //             return $generalEntryDetails->sumDebit;
        //         //         } else if ($generalEntryDetails->sumDebit < 0) {
        //         //             return 0;
        //         //         } else {
        //         //             return null;
        //         //         }
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
        //         ->editColumn('altered_beban', function ($generalEntryDetails) {
        //             $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
        //             $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

        //             if (in_array($generalEntryDetails->account_detail_id, $whereIsBebanDetail)) {
        //                 return $generalEntryDetails->account_detail->nama_rincian_akun;
        //             } else {
        //                 return '-';
        //             }
        //         })
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
        return view('laporan.laporan-laba-rugi.index');
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

                    $whereIsPendapatan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Pendapatan')->first();
                    $whereIsBeban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Beban')->first();

                    $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                    $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                    $whereIsPendapatanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $whereIsBebanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                    $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                    $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                    $labaBersih = $sumPendapatan - $sumBeban;

                    if ($labaBersih < 0) {
                        $labaBersih = '(Rp' . number_format(-($labaBersih), 0, '', '.') . ',-)';
                    } else {
                        $labaBersih = 'Rp' . number_format($labaBersih, 0, '', '.') . ',-';
                    }

                    //Pendapatan
                    $response = '<tr>';
                        $response .= '<td>' . $whereIsPendapatan->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsPendapatan->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($whereIsPendapatanDetails as $whereIsPendapatanDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $whereIsPendapatanDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $whereIsPendapatanDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $whereIsPendapatanDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumPendapatan, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    //Beban
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsBeban->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsBeban->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($whereIsBebanDetails as $whereIsBebanDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $whereIsBebanDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $whereIsBebanDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $whereIsBebanDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumBeban, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td><b>Laba Bersih</b></td>';
                        $response .= '<td><b>' . $labaBersih . '</b></td>';
                    $response .= '</tr>';

                    echo $response;
                }

                else {
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;

                    $currentFromDate = GeneralEntry::whereBetween('tanggal', array($from_date, $to_date))->pluck('id')->toArray();

                    $whereIsPendapatan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Pendapatan')->first();
                    $whereIsBeban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Beban')->first();

                    $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                    $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                    $whereIsPendapatanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                    $whereIsBebanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                    $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                    $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                    $labaBersih = $sumPendapatan - $sumBeban;

                    if ($labaBersih < 0) {
                        $labaBersih = '(Rp' . number_format(-($labaBersih), 0, '', '.') . ',-)';
                    } else {
                        $labaBersih = 'Rp' . number_format($labaBersih, 0, '', '.') . ',-';
                    }

                    //Pendapatan
                    $response = '<tr>';
                        $response .= '<td>' . $whereIsPendapatan->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsPendapatan->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($whereIsPendapatanDetails as $whereIsPendapatanDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $whereIsPendapatanDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $whereIsPendapatanDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $whereIsPendapatanDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('kredit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumPendapatan, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    //Beban
                    $response .= '<tr>';
                        $response .= '<td>' . $whereIsBeban->nomor_akun . '</td>';
                        $response .= '<td>' . $whereIsBeban->nama_akun . '</td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                    $response .= '</tr>';

                    foreach ($whereIsBebanDetails as $whereIsBebanDetail) {
                        $response .= '<tr>';
                            $response .= '<td></td>';
                            $response .= '<td></td>';
                            $response .= '<td>' . $whereIsBebanDetail->account_detail->nomor_rincian_akun . '</td>';
                            $response .= '<td>' . $whereIsBebanDetail->account_detail->nama_rincian_akun . '</td>';
                            $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $whereIsBebanDetail->account_detail_id)->whereIn('general_entry_id', $currentFromDate)->sum('debit'), 0, '' , '.') . ',-</td>';
                        $response .= '</tr>';
                    }

                    $response .= '<tr>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3"></td>';
                        $response .= '<td style="background-color: #D3D3D3">Total</td>';
                        $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumBeban, 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';

                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td><b>Laba Bersih</b></td>';
                        $response .= '<td><b>' . $labaBersih . '</b></td>';
                    $response .= '</tr>';

                    echo $response;
                }
            }

            else {
                $from_date = null;
                $to_date = null;

                $whereIsPendapatan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Pendapatan')->first();
                $whereIsBeban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Beban')->first();

                $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                $whereIsPendapatanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $whereIsBebanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->sum('kredit');
                $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->sum('debit');

                $labaBersih = $sumPendapatan - $sumBeban;

                if ($labaBersih < 0) {
                    $labaBersih = '(Rp' . number_format(-($labaBersih), 0, '', '.') . ',-)';
                } else {
                    $labaBersih = 'Rp' . number_format($labaBersih, 0, '', '.') . ',-';
                }

                //Pendapatan
                $response = '<tr>';
                    $response .= '<td>' . $whereIsPendapatan->nomor_akun . '</td>';
                    $response .= '<td>' . $whereIsPendapatan->nama_akun . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                $response .= '</tr>';

                foreach ($whereIsPendapatanDetails as $whereIsPendapatanDetail) {
                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>' . $whereIsPendapatanDetail->account_detail->nomor_rincian_akun . '</td>';
                        $response .= '<td>' . $whereIsPendapatanDetail->account_detail->nama_rincian_akun . '</td>';
                        $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $whereIsPendapatanDetail->account_detail_id)->sum('kredit'), 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';
                }

                $response .= '<tr>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3">Total</td>';
                    $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumPendapatan, 0, '' , '.') . ',-</td>';
                $response .= '</tr>';

                //Beban
                $response .= '<tr>';
                    $response .= '<td>' . $whereIsBeban->nomor_akun . '</td>';
                    $response .= '<td>' . $whereIsBeban->nama_akun . '</td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                $response .= '</tr>';

                foreach ($whereIsBebanDetails as $whereIsBebanDetail) {
                    $response .= '<tr>';
                        $response .= '<td></td>';
                        $response .= '<td></td>';
                        $response .= '<td>' . $whereIsBebanDetail->account_detail->nomor_rincian_akun . '</td>';
                        $response .= '<td>' . $whereIsBebanDetail->account_detail->nama_rincian_akun . '</td>';
                        $response .= '<td>Rp' . number_format(GeneralEntryDetail::where('account_detail_id', $whereIsBebanDetail->account_detail_id)->sum('debit'), 0, '' , '.') . ',-</td>';
                    $response .= '</tr>';
                }

                $response .= '<tr>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3"></td>';
                    $response .= '<td style="background-color: #D3D3D3">Total</td>';
                    $response .= '<td style="background-color: #D3D3D3">Rp' . number_format($sumBeban, 0, '' , '.') . ',-</td>';
                $response .= '</tr>';

                $response .= '<tr>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td></td>';
                    $response .= '<td><b>Laba Bersih</b></td>';
                    $response .= '<td><b>' . $labaBersih . '</b></td>';
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

                $whereIsPendapatan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Pendapatan')->first();
                $whereIsBeban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Beban')->first();

                $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                $whereIsPendapatanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $whereIsBebanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                $labaBersih = $sumPendapatan - $sumBeban;

                if ($labaBersih < 0) {
                    $labaBersih = '(Rp' . number_format(-($labaBersih), 0, '', '.') . ',-)';
                } else {
                    $labaBersih = 'Rp' . number_format($labaBersih, 0, '', '.') . ',-';
                }
            }

            else {
                $from_date_pdf = $request->from_date_pdf;
                $to_date_pdf = $request->to_date_pdf;

                $currentFromDate = GeneralEntry::whereBetween('tanggal', array($from_date_pdf, $to_date_pdf))->pluck('id')->toArray();

                $whereIsPendapatan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Pendapatan')->first();
                $whereIsBeban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Beban')->first();

                $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
                $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                $whereIsPendapatanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
                $whereIsBebanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

                $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('kredit');
                $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->whereIn('general_entry_id', $currentFromDate)->sum('debit');

                $labaBersih = $sumPendapatan - $sumBeban;

                if ($labaBersih < 0) {
                    $labaBersih = '(Rp' . number_format(-($labaBersih), 0, '', '.') . ',-)';
                } else {
                    $labaBersih = 'Rp' . number_format($labaBersih, 0, '', '.') . ',-';
                }
            }
        }

        else {
            $from_date = null;
            $to_date = null;

            $currentFromDate = GeneralEntry::pluck('id')->toArray();

            $whereIsPendapatan = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Pendapatan')->first();
            $whereIsBeban = Account::select('id', 'nomor_akun', 'nama_akun')->where('nama_akun', 'Beban')->first();

            $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();
            $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

            $whereIsPendapatanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();
            $whereIsBebanDetails = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->orderBy('account_detail_id')->groupBy('account_detail_id')->get();

            $sumPendapatan = GeneralEntryDetail::whereIn('account_detail_id', $whereIsPendapatanDetail)->sum('kredit');
            $sumBeban = GeneralEntryDetail::whereIn('account_detail_id', $whereIsBebanDetail)->sum('debit');

            $labaBersih = $sumPendapatan - $sumBeban;

            if ($labaBersih < 0) {
                $labaBersih = '(Rp' . number_format(-($labaBersih), 0, '', '.') . ',-)';
            } else {
                $labaBersih = 'Rp' . number_format($labaBersih, 0, '', '.') . ',-';
            }
        }

        $pdf = PDF::loadView('pdf.laporan-laba-rugi.index', compact('whereIsPendapatan', 'whereIsBeban', 'whereIsPendapatanDetails', 'whereIsBebanDetails', 'sumPendapatan', 'sumBeban', 'labaBersih', 'currentFromDate'));
        return $pdf->download('Laporan LabaRugi - Salon Fas.pdf');
    }
}
