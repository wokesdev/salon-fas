<?php

namespace App\Http\Controllers;

use App\Models\GeneralEntryDetail;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SaleDetailController extends Controller
{
    public function store(Request $request)
    {
        if (count((array) $request->servis) > 0 && count((array) $request->barang) > 0) {
            $request->validate([
                'id' => 'required|numeric|exists:sales,id',
                'barang.*' => 'required|numeric|exists:items,id',
                'kuantitas.*' => 'required|numeric',
                'harga_satuan.*' => 'required|numeric',
                'subtotal.*' => 'required|numeric',
                'servis.*' => 'required|numeric|exists:services,id',
                'kuantitas_servis.*' => 'required|numeric',
                'harga_satuan_servis.*' => 'required|numeric',
                'subtotal_servis.*' => 'required|numeric',
            ]);

            for($i = 0; $i < count((array) $request->servis); $i++)
            {
                $serviceAlreadyExist = SaleDetail::where('service_id', $request->servis[$i])->where('sale_id', $request->id)->pluck('service_id')->toArray();
                $itemAlreadyExist = SaleDetail::where('item_id', $request->barang[$i])->where('sale_id', $request->id)->pluck('item_id')->toArray();
                if (!in_array($request->barang[$i], $itemAlreadyExist) && !in_array($request->servis[$i], $serviceAlreadyExist)) {
                    $currentTotal = Sale::select('total_servis', 'total_barang', 'total')->where('id', $request->id)->first();
                    $currentStok = Item::select('stok')->where('id', $request->barang[$i])->first();
                    $store = SaleDetail::create([
                        'sale_id' => $request->id,
                        'service_id' => $request->servis[$i],
                        'kuantitas_servis'  => $request->kuantitas_servis[$i],
                        'harga_satuan_servis' => $request->harga_satuan_servis[$i],
                        'subtotal_servis' => $request->subtotal_servis[$i],
                        'item_id' => $request->barang[$i],
                        'kuantitas_barang'  => $request->kuantitas[$i],
                        'harga_satuan_barang' => $request->harga_satuan[$i],
                        'subtotal_barang' => $request->subtotal[$i],
                    ]);

                    $storeStok = Item::where('id', $request->barang[$i])->update([
                        'stok' => $currentStok->stok - $request->kuantitas[$i],
                    ]);

                    $storeTotal = Sale::where('id', $request->id)->update([
                        'total_servis' => $currentTotal->total_servis + $request->subtotal_servis[$i],
                        'total_barang' => $currentTotal->total_barang + $request->subtotal_barang[$i],
                        'total' => $currentTotal->total + $request->subtotal_servis[$i] + $request->subtotal_barang[$i],
                    ]);
                } else {
                    abort(422, 'Servis atau barang sudah terdaftar pada penjualan ini!');
                }
            }
        }

        elseif (count((array) $request->servis) > 0) {
            $request->validate([
                'id' => 'required|numeric|exists:sales,id',
                'servis.*' => 'required|numeric|exists:services,id',
                'kuantitas_servis.*' => 'required|numeric',
                'harga_satuan_servis.*' => 'required|numeric',
                'subtotal_servis.*' => 'required|numeric',
            ]);

            for($i = 0; $i < count((array) $request->servis); $i++)
            {
                $serviceAlreadyExist = SaleDetail::where('service_id', $request->servis[$i])->where('sale_id', $request->id)->pluck('service_id')->toArray();
                if (!in_array($request->servis[$i], $serviceAlreadyExist)) {
                    $currentTotal = Sale::select('total_servis', 'total')->where('id', $request->id)->first();
                    $store = SaleDetail::create([
                        'sale_id' => $request->id,
                        'service_id' => $request->servis[$i],
                        'kuantitas_servis'  => $request->kuantitas_servis[$i],
                        'harga_satuan_servis' => $request->harga_satuan_servis[$i],
                        'subtotal_servis' => $request->subtotal_servis[$i],
                    ]);

                    $storeStok = null;

                    $storeTotal = Sale::where('id', $request->id)->update([
                        'total_servis' => $currentTotal->total_servis + $request->subtotal_servis[$i],
                        'total' => $currentTotal->total + $request->subtotal_servis[$i],
                    ]);
                } else {
                    abort(422, 'Servis sudah terdaftar pada penjualan ini!');
                }
            }
        }

        elseif (count((array) $request->barang) > 0) {
            $request->validate([
                'id' => 'required|numeric|exists:sales,id',
                'barang.*' => 'required|numeric|exists:items,id',
                'kuantitas.*' => 'required|numeric',
                'harga_satuan.*' => 'required|numeric',
                'subtotal.*' => 'required|numeric',
            ]);

            for($i = 0; $i < count((array) $request->barang); $i++)
            {
                $itemAlreadyExist = SaleDetail::where('item_id', $request->barang[$i])->where('sale_id', $request->id)->pluck('item_id')->toArray();
                if (!in_array($request->barang[$i], $itemAlreadyExist)) {
                    $currentTotal = Sale::select('total_barang', 'total')->where('id', $request->id)->first();
                    $currentStok = Item::select('stok')->where('id', $request->barang[$i])->first();
                    $store = SaleDetail::create([
                        'sale_id' => $request->id,
                        'item_id' => $request->barang[$i],
                        'kuantitas_barang'  => $request->kuantitas[$i],
                        'harga_satuan_barang' => $request->harga_satuan[$i],
                        'subtotal_barang' => $request->subtotal[$i],
                    ]);

                    $storeStok = Item::where('id', $request->barang[$i])->update([
                        'stok' => $currentStok->stok - $request->kuantitas[$i],
                    ]);

                    $storeTotal = Sale::where('id', $request->id)->update([
                        'total_barang' => $currentTotal->total_barang + $request->subtotal[$i],
                        'total' => $currentTotal->total + $request->subtotal[$i],
                    ]);
                } else {
                    abort(422, 'Barang sudah terdaftar pada penjualan ini!');
                }
            }
        }

        else {
            abort(422, 'Mohon mengisi data penjualan servis atau barang!');
        }

        if ($store && $storeTotal) {
            $currentSumSubtotalServis = SaleDetail::where('sale_id', $request->id)->sum('subtotal_servis');
            $currentSumSubtotalBarang = SaleDetail::where('sale_id', $request->id)->sum('subtotal_barang');
            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $request->id)->where('kredit', 0)->limit(1)->update([
                'debit' => $currentSumSubtotalServis + $currentSumSubtotalBarang,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $request->id)->where('debit', 0)->limit(1)->update([
                'kredit' => $currentSumSubtotalServis + $currentSumSubtotalBarang,
            ]);
        }
        return response()->json([$store, $storeTotal, $updateGeneralEntryDetail, $storeStok]);
    }

    public function edit(SaleDetail $saleDetail)
    {
        if(request()->ajax()) {
            $edit = SaleDetail::findOrFail($saleDetail->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, SaleDetail $saleDetail)
    {
        if ($request->detailServis != null) {
            $currentTotal = Sale::select('total_servis', 'total')->where('id', $request->saleId)->first();
            $currentSubtotal = $request->currentSubtotalServis != null ? $request->currentSubtotalServis : 0;
            $request->validate([
                'saleId' => 'required|numeric|exists:sales,id',
                'detailServis' => 'required|numeric|exists:services,id',
                'detailKuantitasServis' => 'required|numeric',
                'detailHargaSatuanServis' => 'required|numeric',
                'detailSubtotalServis' => 'required|numeric',
            ]);

            $update = SaleDetail::where('id', $request->detailId)->update([
                'service_id' => $request->detailServis,
                'kuantitas_servis' => $request->detailKuantitasServis,
                'harga_satuan_servis' => $request->detailHargaSatuanServis,
                'subtotal_servis' => $request->detailSubtotalServis,
            ]);

            $updateStok = null;

            $updateTotal = Sale::where('id', $request->saleId)->update([
                'total_servis' => ($currentTotal->total_servis - $request->currentSubtotalServis) + $request->detailSubtotalServis,
                'total' => ($currentTotal->total - $currentSubtotal) + $request->detailSubtotalServis,
            ]);
        }

        elseif ($request->detailBarang != null) {
            $currentTotal = Sale::select('total_barang', 'total')->where('id', $request->saleId)->first();
            $currentSubtotal = $request->currentSubtotalBarang != null ? $request->currentSubtotalBarang : 0;
            $currentStok = Item::select('stok')->where('id', $request->detailBarang)->first();
            $request->validate([
                'saleId' => 'required|numeric|exists:sales,id',
                'detailBarang' => 'required|numeric|exists:items,id',
                'detailKuantitasBarang' => 'required|numeric',
                'detailHargaSatuanBarang' => 'required|numeric',
                'detailSubtotalBarang' => 'required|numeric',
            ]);

            $update = SaleDetail::where('id', $request->detailId)->update([
                'item_id' => $request->detailBarang,
                'kuantitas_barang' => $request->detailKuantitasBarang,
                'harga_satuan_barang' => $request->detailHargaSatuanBarang,
                'subtotal_barang' => $request->detailSubtotalBarang,
            ]);

            $updateStok = Item::where('id', $request->detailBarang)->update([
                'stok' => $currentStok->stok - $request->detailKuantitasBarang,
            ]);

            $updateTotal = Sale::where('id', $request->saleId)->update([
                'total_barang' => ($currentTotal->total_barang - $request->currentSubtotalBarang) + $request->detailSubtotalBarang,
                'total' => ($currentTotal->total - $currentSubtotal) + $request->detailSubtotalBarang,
            ]);
        }

        if ($update && $updateTotal) {
            $currentSumSubtotalServis = SaleDetail::where('sale_id', $request->saleId)->sum('subtotal_servis');
            $currentSumSubtotalBarang = SaleDetail::where('sale_id', $request->saleId)->sum('subtotal_barang');
            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $request->saleId)->where('kredit', 0)->update([
                'debit' => $currentSumSubtotalServis + $currentSumSubtotalBarang,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $request->saleId)->where('debit', 0)->update([
                'kredit' => $currentSumSubtotalServis + $currentSumSubtotalBarang,
            ]);
        }
        return response()->json([$update, $updateTotal, $updateGeneralEntryDetail, $updateStok]);
    }

    public function destroy(SaleDetail $saleDetail)
    {
        $currentTotal = Sale::select('total', 'total_barang', 'total_servis')->where('id', $saleDetail->sale_id)->first();
        $currentStok = Item::select('stok')->where('id', $saleDetail->item_id)->first();

        if ($currentStok !== null) {
            $destroyStok = Item::where('id', $saleDetail->item_id)->update([
                'stok' => $currentStok->stok + $saleDetail->kuantitas_barang,
            ]);

            $destroyTotal = Sale::where('id', $saleDetail->sale_id)->update([
                'total_servis' => $currentTotal->total_servis - $saleDetail->subtotal_servis,
                'total_barang' => $currentTotal->total_barang - $saleDetail->subtotal_barang,
                'total' => $currentTotal->total - ($saleDetail->subtotal_barang + $saleDetail->subtotal_servis),
            ]);

            $destroy = SaleDetail::where('id', $saleDetail->id)->delete();
        } else {
            $destroyStok = null;

            $destroyTotal = Sale::where('id', $saleDetail->sale_id)->update([
                'total_servis' => $currentTotal->total_servis - $saleDetail->subtotal_servis,
                'total_barang' => $currentTotal->total_barang - $saleDetail->subtotal_barang,
                'total' => $currentTotal->total - ($saleDetail->subtotal_barang + $saleDetail->subtotal_servis),
            ]);

            $destroy = SaleDetail::where('id', $saleDetail->id)->delete();
        }

        if ($destroy && $destroyTotal) {
            $currentSumSubtotalServis = SaleDetail::where('sale_id', $saleDetail->sale_id)->sum('subtotal_servis');
            $currentSumSubtotalBarang = SaleDetail::where('sale_id', $saleDetail->sale_id)->sum('subtotal_barang');
            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $saleDetail->sale_id)->where('kredit', 0)->update([
                'debit' => $currentSumSubtotalServis + $currentSumSubtotalBarang,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $saleDetail->sale_id)->where('debit', 0)->update([
                'kredit' => $currentSumSubtotalServis + $currentSumSubtotalBarang,
            ]);
        }
        return response()->json([$destroy, $destroyTotal, $updateGeneralEntryDetail, $destroyStok]);
    }
}
