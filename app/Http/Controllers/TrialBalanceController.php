<?php

namespace App\Http\Controllers;

use App\Models\GeneralEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TrialBalanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
                if ($request->from_date === $request->to_date) {
                    $from_date = $request->from_date;
                    $generalEntryDetails = GeneralEntryDetail::select('*', DB::raw('SUM(debit - kredit) as sumDebitKredit'))
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
                    ->with(['account_detail', 'general_entry'])
                    ->groupBy('account_detail_id')
                    ->get();
            }
            return DataTables::of($generalEntryDetails)
                ->editColumn('altered_debit', function ($generalEntryDetails) {
                    if ($generalEntryDetails->sumDebitKredit > 0) {
                        return $generalEntryDetails->sumDebitKredit;
                    } else if ($generalEntryDetails->sumDebitKredit < 0) {
                        return 0;
                    } else {
                        return null;
                    }
                })
                ->editColumn('altered_kredit', function ($generalEntryDetails) {
                    if ($generalEntryDetails->sumDebitKredit < 0) {
                        return -($generalEntryDetails->sumDebitKredit);
                    } else if ($generalEntryDetails->sumDebitKredit > 0) {
                        return 0;
                    } else {
                        return null;
                    }
                })
                ->make(true);
        }
        return view('laporan.neraca-saldo.index');
    }
}
