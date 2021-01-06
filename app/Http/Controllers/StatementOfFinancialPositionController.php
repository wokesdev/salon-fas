<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountDetail;
use App\Models\GeneralEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StatementOfFinancialPositionController extends Controller
{
    public function index(Request $request)
    {
        $whereIsAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
        $whereIsKewajiban = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->pluck('id')->toArray();
        $whereIsModal = Account::where('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
        $whereIsAktivaKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsAktiva)->orWhereIn('account_id', $whereIsKewajiban)->orWhereIn('account_id', $whereIsModal)->pluck('id')->toArray();

        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
                if ($request->from_date === $request->to_date) {
                    $from_date = $request->from_date;
                    $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit - kredit) as sumDebitKredit'))
                        ->whereIn('account_detail_id', $whereIsAktivaKewajibanModalDetail)
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
                    $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit - kredit) as sumDebitKredit'))
                        ->whereIn('account_detail_id', $whereIsAktivaKewajibanModalDetail)
                        ->with(['account_detail', 'general_entry'])
                        ->whereHas('general_entry', function ($query) use($from_date, $to_date) {
                            return $query->whereBetween('general_entries.tanggal', array($from_date, $to_date));
                        })
                        ->groupBy('account_detail_id')
                        ->get();
                }
            }

            else {
                $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit - kredit) as sumDebitKredit'))
                    ->whereIn('account_detail_id', $whereIsAktivaKewajibanModalDetail)
                    ->with(['account_detail', 'general_entry'])
                    ->groupBy('account_detail_id')
                    ->get();
            }

            return DataTables::of($generalEntryDetails)
                ->editColumn('altered_jenis_aktiva', function ($generalEntryDetails) {
                    $whereIsAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
                    $whereIsAktivaDetail = AccountDetail::whereIn('account_id', $whereIsAktiva)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereIsAktivaDetail)) {
                        return $generalEntryDetails->account_detail->account->nama_akun;
                    } else {
                        return '-';
                    }
                })
                ->editColumn('altered_aktiva', function ($generalEntryDetails) {
                    $whereIsAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
                    $whereIsAktivaDetail = AccountDetail::whereIn('account_id', $whereIsAktiva)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereIsAktivaDetail)) {
                        return $generalEntryDetails->account_detail->nama_rincian_akun;
                    } else {
                        return '-';
                    }
                })
                ->editColumn('altered_nominal_aktiva', function ($generalEntryDetails) {
                    $whereisAktiva = Account::where('nama_akun', 'LIKE', '%Aktiva%')->pluck('id')->toArray();
                    $whereisAktivaDetail = AccountDetail::whereIn('account_id', $whereisAktiva)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereisAktivaDetail)) {
                        if ($generalEntryDetails->sumDebitKredit > 0) {
                            return $generalEntryDetails->sumDebitKredit;
                        } else if ($generalEntryDetails->sumDebitKredit < 0) {
                            return -($generalEntryDetails->sumDebitKredit);
                        } else {
                            return null;
                        }
                    } else {
                        return 0;
                    }
                })
                ->editColumn('altered_jenis_kewajiban_modal', function ($generalEntryDetails) {
                    $whereIsKewajibanModal = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->orWhere('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
                    $whereIsKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsKewajibanModal)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereIsKewajibanModalDetail)) {
                        return $generalEntryDetails->account_detail->account->nama_akun;
                    } else {
                        return '-';
                    }
                })
                ->editColumn('altered_kewajiban_modal', function ($generalEntryDetails) {
                    $whereIsKewajibanModal = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->orWhere('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
                    $whereIsKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsKewajibanModal)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereIsKewajibanModalDetail)) {
                        return $generalEntryDetails->account_detail->nama_rincian_akun;
                    } else {
                        return '-';
                    }
                })
                // ->editColumn('altered_nominal_kewajiban_modal', function ($generalEntryDetails) {
                //     if ($generalEntryDetails->sumDebitKredit > 0) {
                //         return $generalEntryDetails->sumDebitKredit;
                //     } else if ($generalEntryDetails->sumDebitKredit < 0) {
                //         return -($generalEntryDetails->sumDebitKredit);
                //     } else {
                //         return null;
                //     }
                // })
                ->editColumn('altered_nominal_kewajiban_modal', function ($generalEntryDetails) {
                    $whereIsKewajibanModal = Account::where('nama_akun', 'LIKE', '%Liabilitas%')->orWhere('nama_akun', 'LIKE', '%Ekuitas%')->pluck('id')->toArray();
                    $whereIsKewajibanModalDetail = AccountDetail::whereIn('account_id', $whereIsKewajibanModal)->pluck('id')->toArray();

                    if (in_array($generalEntryDetails->account_detail_id, $whereIsKewajibanModalDetail)) {
                        if ($generalEntryDetails->sumDebitKredit > 0) {
                            return $generalEntryDetails->sumDebitKredit;
                        } else if ($generalEntryDetails->sumDebitKredit < 0) {
                            return -($generalEntryDetails->sumDebitKredit);
                        } else {
                            return null;
                        }
                    } else {
                        return 0;
                    }
                })
                // ->editColumn('altered_beban', function ($generalEntryDetails) {
                //     $whereIsBeban = Account::select('id')->where('nama_akun', 'Beban')->first();
                //     $whereIsBebanDetail = AccountDetail::where('account_id', $whereIsBeban->id)->pluck('id')->toArray();

                //     if (in_array($generalEntryDetails->account_detail_id, $whereIsBebanDetail)) {
                //         return $generalEntryDetails->account_detail->nama_rincian_akun;
                //     } else {
                //         return '-';
                //     }
                // })
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
        return view('laporan.laporan-posisi-keuangan.index');
    }
}
