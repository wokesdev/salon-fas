<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetail;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:purchases,id',
            'kuantitas' => 'required|array',
            'kuantitas.*' => 'required|numeric',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
            'keterangan' => 'required|array',
            'keterangan.*' => 'required|string|max:500',
        ]);

        for($i = 0; $i < count((array) $request->kuantitas); $i++)
        {
            $store = PurchaseDetail::create([
                'purchase_id' => $request->id,
                'kuantitas'  => $request->kuantitas[$i],
                'harga_satuan' => $request->price[$i],
                'total' => $request->kuantitas[$i] * $request->price[$i],
                'keterangan' => $request->keterangan[$i],
            ]);
        }
        return response()->json($store);
    }

    public function edit(PurchaseDetail $purchaseDetail)
    {
        if(request()->ajax()) {
            $edit = PurchaseDetail::findOrFail($purchaseDetail->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, PurchaseDetail $purchaseDetail)
    {
        request()->validate([
            'detailKuantitas' => 'required|numeric',
            'detailPrice' => 'required|numeric',
            'detailKeterangan' => 'required|string|max:500',
        ]);

        $update = PurchaseDetail::where('id', $request->detailId)->update([
            'kuantitas' => $request->detailKuantitas,
            'harga_satuan' => $request->detailPrice,
            'total' => $request->detailPrice * $request->detailKuantitas,
            'keterangan' => $request->detailKeterangan,
        ]);
        return response()->json($update);
    }

    public function destroy(PurchaseDetail $purchaseDetail)
    {
        $destroy = PurchaseDetail::where('id', $purchaseDetail->id)->delete();
        return response()->json($destroy);
    }
}
