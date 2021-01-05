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
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->get();
        $totalDebit = 1;
        $totalKredit = 1;
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

                    $totalDebit = GeneralEntryDetail::where('account_detail_id', $request->rincian_akun)->where('kredit', 0)->sum('debit');
                    $totalKredit = GeneralEntryDetail::where('account_detail_id', $request->rincian_akun)->where('debit', 0)->sum('kredit');
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
                    }

                    else if (!empty($generalEntryDetails->sale_id)) {
                        return $generalEntryDetails->sale->keterangan;
                    }

                    else if (!empty($generalEntryDetails->cash_payment_id)) {
                        return $generalEntryDetails->cash_payment->keterangan;
                    }

                    else if (!empty($generalEntryDetails->cash_receipt_id)) {
                        return $generalEntryDetails->cash_receipt->keterangan;
                    }

                    else {
                        return null;
                    }
                })
                ->make(true);
        }
        return view('laporan.buku-besar.index', compact('accountDetails', 'totalDebit', 'totalKredit'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger $ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ledger $ledger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger $ledger)
    {
        //
    }
}
