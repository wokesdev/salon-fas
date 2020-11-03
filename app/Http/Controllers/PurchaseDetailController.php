<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PurchaseDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchases = Purchase::select('id', 'nomor_pembelian', 'account_detail_id', 'keterangan')->get();
        if ($request->ajax()) {
            $purchaseDetail = PurchaseDetail::query();
            return DataTables::of($purchaseDetail)
                ->addColumn('action', function($purchaseDetail){
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$purchaseDetail->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$purchaseDetail->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->editColumn('nomor_pembelian', function($purchaseDetail) {
                    return $purchaseDetail->purchase->nomor_pembelian;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('transaksi.purchase-details.index', compact('purchases'));
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
        $total = $request->price * $request->kuantitas;

        request()->validate([
            'purchase_id' => 'required|numeric',
            'keterangan' => 'required|string|max:500',
            'kuantitas' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $store = PurchaseDetail::create([
            'purchase_id' => $request->purchase_id,
            'keterangan' => $request->keterangan,
            'kuantitas' => $request->kuantitas,
            'harga_satuan' => $request->price,
            'total' => $total,
        ]);

        return response()->json($store);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseDetail $purchaseDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseDetail $purchaseDetail)
    {
        if(request()->ajax()) {
            $edit = PurchaseDetail::findOrFail($purchaseDetail->id);
            return response()->json($edit);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseDetail $purchaseDetail)
    {
        $total = $request->price * $request->kuantitas;

        request()->validate([
            'purchase_id' => 'required|numeric',
            'keterangan' => 'required|string|max:500',
            'kuantitas' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $update = PurchaseDetail::where('id', $request->id)->update([
            'purchase_id' => $request->purchase_id,
            'keterangan' => $request->keterangan,
            'kuantitas' => $request->kuantitas,
            'harga_satuan' => $request->price,
            'total' => $total,
        ]);

        return response()->json($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseDetail $purchaseDetail)
    {
        $destroy = PurchaseDetail::where('id', $purchaseDetail->id)->delete();
        return response()->json($destroy);
    }
}
