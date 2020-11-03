<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\AccountDetail;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->get();
        $suppliers = Supplier::select('id', 'code', 'name')->get();
        if ($request->ajax()) {
            $purchase = Purchase::query();
            return DataTables::of($purchase)
                ->addColumn('action', function($purchase){
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$purchase->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$purchase->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->editColumn('nomor_rincian_akun', function($purchase) {
                    return $purchase->account_detail->nomor_rincian_akun;
                })
                ->editColumn('nama_rincian_akun', function($purchase) {
                    return $purchase->account_detail->nama_rincian_akun;
                })
                ->editColumn('kode_supplier', function($purchase) {
                    return $purchase->supplier->code;
                })
                ->editColumn('nama_supplier', function($purchase) {
                    return $purchase->supplier->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.purchases.index', compact('accountDetails', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $statement = DB::select("show table status like 'purchases'");
        $number = $statement[0]->Auto_increment;
        $code = 'PC' . str_pad($number, 5, '0', STR_PAD_LEFT);

        request()->validate([
            'account_detail_id' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:500',
        ]);

        $store = Purchase::create([
            'nomor_pembelian' => $code,
            'account_detail_id' => $request->account_detail_id,
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json($store);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        if(request()->ajax()) {
            $edit = Purchase::findOrFail($purchase->id);
            return response()->json($edit);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        request()->validate([
            'account_detail_id' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:500',
        ]);

        $update = Purchase::where('id', $request->id)->update([
            'account_detail_id' => $request->account_detail_id,
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $destroy = Purchase::where('id', $purchase->id)->delete();
        return response()->json($destroy);
    }
}
