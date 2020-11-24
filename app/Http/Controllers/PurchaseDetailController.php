<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetail;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|exists:purchases,id',
            'barang.*' => 'required|numeric|exists:items,id',
            'kuantitas.*' => 'required|numeric',
            'harga_satuan.*' => 'required|numeric',
            'subtotal.*' => 'required|numeric',
        ]);

        for($i = 0; $i < count((array) $request->kuantitas); $i++)
        {
            $itemAlreadyExist = PurchaseDetail::where('item_id', $request->barang[$i])->where('purchase_id', $request->id)->pluck('item_id')->toArray();
            if (!in_array($request->barang[$i], $itemAlreadyExist)) {
                $currentTotal = Purchase::select('total')->where('id', $request->id)->first();
                $store = PurchaseDetail::create([
                    'purchase_id' => $request->id,
                    'item_id' => $request->barang[$i],
                    'kuantitas'  => $request->kuantitas[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);

                $storeTotal = Purchase::where('id', $request->id)->update([
                    'total' => $currentTotal->total + $request->subtotal[$i],
                ]);
            } else {
                $request->validate([
                    'barang.*' => 'required|numeric|exists:purchase_details,item_id',
                ]);
                abort(422, 'Barang sudah ada!');
            }
        }
        return response()->json([$store, $storeTotal]);
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
        $currentTotal = Purchase::select('total')->where('id', $request->purchaseId)->first();
        $request->validate([
            'purchaseId' => 'required|numeric|exists:purchases,id',
            'detailBarang' => 'required|numeric|exists:items,id',
            'detailKuantitas' => 'required|numeric',
            'detailHargaSatuan' => 'required|numeric',
            'detailSubtotal' => 'required|numeric',
        ]);

        $update = PurchaseDetail::where('id', $request->detailId)->update([
            'item_id' => $request->detailBarang,
            'kuantitas' => $request->detailKuantitas,
            'harga_satuan' => $request->detailHargaSatuan,
            'subtotal' => $request->detailSubtotal,
        ]);

        $updateTotal = Purchase::where('id', $request->purchaseId)->update([
            'total' => ($currentTotal->total - $request->currentSubtotal) + $request->detailSubtotal,
        ]);
        return response()->json([$update, $updateTotal]);
    }

    public function destroy(PurchaseDetail $purchaseDetail)
    {
        $currentTotal = Purchase::select('total')->where('id', $purchaseDetail->purchase_id)->first();
        $destroy = PurchaseDetail::where('id', $purchaseDetail->id)->delete();
        $destroyTotal = Purchase::where('id', $purchaseDetail->purchase_id)->update([
            'total' => $currentTotal->total - $purchaseDetail->subtotal,
        ]);
        return response()->json([$destroy, $destroyTotal]);
    }
}
