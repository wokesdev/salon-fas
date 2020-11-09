<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SaleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sales = Sale::select('id', 'nomor_pembelian', 'account_detail_id', 'keterangan')->get();
        if ($request->ajax()) {
            $saleDetail = SaleDetail::query();
            return DataTables::of($saleDetail)
                ->addColumn('action', function($saleDetail){
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$saleDetail->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$saleDetail->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->editColumn('nomor_pembelian', function($saleDetail) {
                    return $saleDetail->sale->nomor_penjualan;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('transaksi.sale-details.index', compact('sales'));
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
            'sale_id' => 'required|numeric',
            'keterangan' => 'required|string|max:500',
            'kuantitas' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $store = SaleDetail::create([
            'sale_id' => $request->sale_id,
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
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function show(SaleDetail $saleDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleDetail $saleDetail)
    {
        if(request()->ajax()) {
            $edit = SaleDetail::findOrFail($saleDetail->id);
            return response()->json($edit);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleDetail $saleDetail)
    {
        $total = $request->price * $request->kuantitas;

        request()->validate([
            'sale_id' => 'required|numeric',
            'keterangan' => 'required|string|max:500',
            'kuantitas' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $update = SaleDetail::where('id', $request->id)->update([
            'sale_id' => $request->sale_id,
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
     * @param  \App\Models\SaleDetail  $saleDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleDetail $saleDetail)
    {
        $destroy = SaleDetail::where('id', $saleDetail->id)->delete();
        return response()->json($destroy);
    }
}
