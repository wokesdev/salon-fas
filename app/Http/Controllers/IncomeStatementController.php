<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountDetail;
use App\Models\GeneralEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IncomeStatementController extends Controller
{
    public function index(Request $request)
    {
        $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
        $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
        $whereIsPendapatanBebanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->orWhere('account_id', $whereIsBeban->id)->pluck('id')->toArray();

        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
                if ($request->from_date === $request->to_date) {
                    $from_date = $request->from_date;
                    $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit) as sumDebit'), DB::raw('SUM(kredit) as sumKredit'))
                        ->whereIn('account_detail_id', $whereIsPendapatanBebanDetail)
                        ->with(['account_detail', 'general_entry'])
                        ->whereHas('general_entry', function ($query) use($from_date) {
                            return $query->whereDate('tanggal', '=', $from_date);
                        })
                        ->groupBy('account_detail_id')
                        ->get();
                }

                else {
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;
                    $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit) as sumDebit'), DB::raw('SUM(kredit) as sumKredit'))
                        ->whereIn('account_detail_id', $whereIsPendapatanBebanDetail)
                        ->with(['account_detail', 'general_entry'])
                        ->whereHas('general_entry', function ($query) use($from_date, $to_date) {
                            return $query->whereBetween('general_entries.tanggal', array($from_date, $to_date));
                        })
                        ->groupBy('account_detail_id')
                        ->get();
                }
            }

            else {
                $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit) as sumDebit'), DB::raw('SUM(kredit) as sumKredit'))
                    ->whereIn('account_detail_id', $whereIsPendapatanBebanDetail)
                    ->with(['account_detail', 'general_entry'])
                    ->groupBy('account_detail_id')
                    ->get();
            }

            return DataTables::of($generalEntryDetails)
                ->editColumn('altered_pendapatan', function ($generalEntryDetails) {
                    $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
                    $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereIsPendapatanDetail)) {
                        return $generalEntryDetails->account_detail->nama_rincian_akun;
                    } else {
                        return '-';
                    }
                })
                // ->editColumn('altered_nominal_pendapatan', function ($generalEntryDetails) {
                //     $whereIsPendapatan = Account::select('id')->where('nama_akun', 'Pendapatan')->first();
                //     $whereIsPendapatanDetail = AccountDetail::where('account_id', $whereIsPendapatan->id)->pluck('id')->toArray();

                //     if (in_array($generalEntryDetails->account_detail_id, $whereIsPendapatanDetail)) {
                //         if ($generalEntryDetails->sumDebit > 0) {
                //             return $generalEntryDetails->sumDebit;
                //         } else if ($generalEntryDetails->sumDebit < 0) {
                //             return 0;
                //         } else {
                //             return null;
                //         }
                //         if (!empty($generalEntryDetails->purchase_id)) {
                //             return $generalEntryDetails->purchase->total;
                //         } else if (!empty($generalEntryDetails->sale_id)) {
                //             return $generalEntryDetails->sale->total;
                //         } else if (!empty($generalEntryDetails->cash_payment_id)) {
                //             return $generalEntryDetails->cash_payment->jumlah;
                //         } else if (!empty($generalEntryDetails->cash_receipt_id)) {
                //             return $generalEntryDetails->cash_receipt->jumlah;
                //         } else {
                //             return null;
                //         }
                //     } else {
                //         return 0;
                //     }
                // })
                ->editColumn('altered_beban', function ($generalEntryDetails) {
                    $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
                    $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereIsBebanDetail)) {
                        return $generalEntryDetails->account_detail->nama_rincian_akun;
                    } else {
                        return '-';
                    }
                })
                // ->editColumn('altered_nominal_beban', function ($generalEntryDetails) {
                //     $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
                //     $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                //     if (in_array($generalEntryDetails->account_detail_id, $whereIsBebanDetail)) {
                //         if (!empty($generalEntryDetails->purchase_id)) {
                //             return $generalEntryDetails->purchase->total;
                //         } else if (!empty($generalEntryDetails->sale_id)) {
                //             return $generalEntryDetails->sale->total;
                //         } else if (!empty($generalEntryDetails->cash_payment_id)) {
                //             return $generalEntryDetails->cash_payment->jumlah;
                //         } else if (!empty($generalEntryDetails->cash_receipt_id)) {
                //             return $generalEntryDetails->cash_receipt->jumlah;
                //         } else {
                //             return null;
                //         }
                //     } else {
                //         return 0;
                //     }
                // })
                ->make(true);
        }
        return view('laporan.laporan-laba-rugi.index');
    }
}
