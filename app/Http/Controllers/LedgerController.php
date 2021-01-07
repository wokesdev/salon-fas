<?php

namespace App\Http\Controllers;

use App\Models\AccountDetail;
use App\Models\GeneralEntryDetail;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->orderBy('nomor_rincian_akun', 'ASC')->get();
        if ($request->ajax()) {
            if(!empty($request->rincian_akun)) {
                if(!empty($request->from_date))
                {
                    if ($request->from_date === $request->to_date) {
                        $from_date = $request->from_date;
                        $generalEntryDetails = GeneralEntryDetail::query()
                            ->where('account_detail_id', $request->rincian_akun)
                            ->with(['account_detail', 'general_entry', 'purchase', 'sale', 'cash_payment', 'cash_receipt'])
                            ->whereHas('general_entry', function ($query) use($from_date) {
                                return $query->whereDate('tanggal', '=', $from_date);
                            })
                            ->get();
                    }

                    else {
                        $from_date = $request->from_date;
                        $to_date = $request->to_date;
                        $generalEntryDetails = GeneralEntryDetail::query()
                            ->where('account_detail_id', $request->rincian_akun)
                            ->with(['account_detail', 'general_entry', 'purchase', 'sale', 'cash_payment', 'cash_receipt'])
                            ->whereHas('general_entry', function ($query) use($from_date, $to_date) {
                                return $query->whereBetween('general_entries.tanggal', array($from_date, $to_date));
                            })
                            ->get();
                    }
                }

                else {
                    $generalEntryDetails = GeneralEntryDetail::query()
                        ->where('account_detail_id', $request->rincian_akun)
                        ->with(['general_entry', 'account_detail', 'purchase', 'sale', 'cash_payment', 'cash_receipt'])
                        ->get();
                }
            }

            else {
                $generalEntryDetails = GeneralEntryDetail::query()
                    ->with(['general_entry', 'account_detail', 'purchase', 'sale', 'cash_payment', 'cash_receipt'])
                    ->get();
            }
            return DataTables::of($generalEntryDetails)
                ->editColumn('keterangan', function($generalEntryDetails){
                    if (!empty($generalEntryDetails->purchase_id)) {
                        return $generalEntryDetails->purchase->keterangan;
                    } else if (!empty($generalEntryDetails->sale_id)) {
                        return $generalEntryDetails->sale->keterangan;
                    } else if (!empty($generalEntryDetails->cash_payment_id)) {
                        return $generalEntryDetails->cash_payment->keterangan;
                    } else if (!empty($generalEntryDetails->cash_receipt_id)) {
                        return $generalEntryDetails->cash_receipt->keterangan;
                    } else {
                        return null;
                    }
                })
                ->make(true);
        }
        return view('laporan.buku-besar.index', compact('accountDetails'));
    }
}
