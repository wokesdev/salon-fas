<?php

namespace App\Http\Controllers;

use App\Models\GeneralEntry;
use App\Models\GeneralEntryDetail;
use App\Models\Item;
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
            $currentItem = Item::select('nama')->where('id', $request->barang[$i])->first();
            if (!in_array($request->barang[$i], $itemAlreadyExist)) {
                $currentTotal = Purchase::select('total')->where('id', $request->id)->first();
                $store = PurchaseDetail::create([
                    'purchase_id' => $request->id,
                    'item_id' => $request->barang[$i],
                    'kuantitas'  => $request->kuantitas[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'subtotal' => $request->subtotal[$i],
                    'keterangan' => 'Pembelian ' . $currentItem->nama,
                ]);

                $storeTotal = Purchase::where('id', $request->id)->update([
                    'total' => $currentTotal->total + $request->subtotal[$i],
                ]);
            }

            else {
                abort(422, 'Barang sudah terdaftar pada pembelian ini!');
            }
        }

        if ($store && $storeTotal) {
            $currentSumSubtotal = PurchaseDetail::where('purchase_id', $request->id)->sum('subtotal');
            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $request->id)->where('kredit', 0)->limit(1)->update([
                'debit' => $currentSumSubtotal,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $request->id)->where('debit', 0)->limit(1)->update([
                'kredit' => $currentSumSubtotal,
            ]);
        }
        return response()->json([$store, $storeTotal, $updateGeneralEntryDetail]);
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
        $currentItem = Item::select('nama')->where('id', $request->detailBarang)->first();

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
            'keterangan' => 'Pembelian ' . $currentItem->nama,
        ]);

        $updateTotal = Purchase::where('id', $request->purchaseId)->update([
            'total' => ($currentTotal->total - $request->currentSubtotal) + $request->detailSubtotal,
        ]);

        if ($update && $updateTotal) {
            $currentSumSubtotal = PurchaseDetail::where('purchase_id', $request->purchaseId)->sum('subtotal');
            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $request->purchaseId)->where('kredit', 0)->update([
                'debit' => $currentSumSubtotal,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $request->purchaseId)->where('debit', 0)->update([
                'kredit' => $currentSumSubtotal,
            ]);
        }
        return response()->json([$update, $updateTotal, $updateGeneralEntryDetail]);
    }

    public function destroy(PurchaseDetail $purchaseDetail)
    {
        $currentTotal = Purchase::select('total')->where('id', $purchaseDetail->purchase_id)->first();
        $destroyTotal = Purchase::where('id', $purchaseDetail->purchase_id)->update([
            'total' => $currentTotal->total - $purchaseDetail->subtotal,
        ]);
        $destroy = PurchaseDetail::where('id', $purchaseDetail->id)->delete();

        if ($destroy && $destroyTotal) {
            $currentSumSubtotal = PurchaseDetail::where('purchase_id', $purchaseDetail->purchase_id)->sum('subtotal');
            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $purchaseDetail->purchase_id)->where('kredit', 0)->update([
                'debit' => $currentSumSubtotal,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $purchaseDetail->purchase_id)->where('debit', 0)->update([
                'kredit' => $currentSumSubtotal,
            ]);
        }
        return response()->json([$destroy, $destroyTotal, $updateGeneralEntryDetail]);
    }
}
