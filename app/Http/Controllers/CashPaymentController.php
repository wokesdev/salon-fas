<?php

namespace App\Http\Controllers;

use App\Models\CashPayment;
use App\Models\AccountDetail;
use App\Models\GeneralEntry;
use App\Models\GeneralEntryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CashPaymentController extends Controller
{
    public function index(Request $request)
    {
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->orderBy('nomor_rincian_akun', 'ASC')->get();
        if ($request->ajax()) {
            $cashPayment = CashPayment::query()->with('account_detail');
            return DataTables::of($cashPayment)
                ->addColumn('action', function($cashPayment){
                        $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$cashPayment->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$cashPayment->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                        return $button;
                    })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.cash-payment.index', compact('accountDetails'));
    }

    public function store(Request $request)
    {
        $statement = DB::select("show table status like 'cash_payments'");
        $number = $statement[0]->Auto_increment;

        $request->validate([
            'rincian_akun' => 'required|numeric|exists:account_details,id',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string|max:500',
            'tanggal' => 'required|date',
        ]);

        $store = CashPayment::create([
            'nomor_nota' => $number,
            'account_detail_id' => $request->rincian_akun,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        if ($store) {
            $statementGeneralEntry = DB::select("show table status like 'general_entries'");
            $numberGeneralEntry = $statementGeneralEntry[0]->Auto_increment;
            $kasOnAccountDetail = AccountDetail::select('id')->where('nama_rincian_akun', 'Kas')->first();

            $storeGeneralEntry = GeneralEntry::create([
                'cash_payment_id' => $number,
                'nomor_transaksi' => $numberGeneralEntry,
                'tanggal' => $request->tanggal,
            ]);

            $storeGeneralEntryDetail = GeneralEntryDetail::create([
                'cash_payment_id' => $number,
                'account_detail_id' => $request->rincian_akun,
                'general_entry_id' => $numberGeneralEntry,
                'debit' => $request->jumlah,
                'kredit' => 0,
            ]);

            $storeGeneralEntryDetail = GeneralEntryDetail::create([
                'cash_payment_id' => $number,
                'account_detail_id' => $kasOnAccountDetail->id,
                'general_entry_id' => $numberGeneralEntry,
                'debit' => 0,
                'kredit' => $request->jumlah,
            ]);
        }
        return response()->json([$store, $storeGeneralEntry, $storeGeneralEntryDetail]);
    }

    public function edit(CashPayment $cashPayment)
    {
        if(request()->ajax()) {
            $edit = CashPayment::findOrFail($cashPayment->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, CashPayment $cashPayment)
    {
        $request->validate([
            'rincian_akun' => 'required|numeric|exists:account_details,id',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string|max:500',
            'tanggal' => 'required|date',
        ]);

        $update = CashPayment::where('id', $request->id)->update([
            'account_detail_id' => $request->rincian_akun,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        if ($update) {
            $updateGeneralEntry = GeneralEntry::where('cash_payment_id', $request->id)->update([
                'tanggal' => $request->tanggal,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('cash_payment_id', $request->id)->where('kredit', 0)->update([
                'account_detail_id' => $request->rincian_akun,
                'debit' => $request->jumlah,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('cash_payment_id', $request->id)->where('debit', 0)->update([
                'kredit' => $request->jumlah,
            ]);
        }
        return response()->json([$update, $updateGeneralEntry, $updateGeneralEntryDetail]);
    }

    public function destroy(CashPayment $cashPayment)
    {
        $destroy = CashPayment::where('id', $cashPayment->id)->delete();
        return response()->json($destroy);
    }
}
