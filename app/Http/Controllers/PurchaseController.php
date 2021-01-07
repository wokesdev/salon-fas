<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\AccountDetail;
use App\Models\GeneralEntry;
use App\Models\GeneralEntryDetail;
use App\Models\PurchaseDetail;
use App\Models\Item;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->orderBy('nomor_rincian_akun', 'ASC')->get();
        $suppliers = Supplier::select('id', 'kode_supplier', 'nama')->orderBy('kode_supplier', 'ASC')->get();
        $items = Item::select('id', 'nama')->orderBy('nama', 'ASC')->get();
        if ($request->ajax()) {
            $purchase = Purchase::query()->with(['supplier', 'account_detail']);
            return DataTables::of($purchase)
                ->addColumn('action', function($purchase) {
                    $button = '<div class="form-button-action"><button type="button" name="detail" data-toggle="tooltip" data-id="'.$purchase->id.'" data-original-title="Detail" class="detail btn btn-warning btn-sm">Detail</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" data-toggle="tooltip" data-id="'.$purchase->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$purchase->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.purchase.index', compact('accountDetails', 'suppliers', 'items'));
    }

    public function store(Request $request)
    {
        $statement = DB::select("show table status like 'purchases'");
        $number = $statement[0]->Auto_increment;
        $code = 'PC' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $request->validate([
            'rincian_akun' => 'required|numeric|exists:account_details,id',
            'rincian_akun_pembayaran' => 'required|numeric|exists:account_details,id',
            'supplier' => 'required|numeric|exists:suppliers,id',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
            'barang.*' => 'required|numeric|exists:items,id',
            'kuantitas.*' => 'required|numeric',
            'harga_satuan.*' => 'required|numeric',
            'subtotal.*' => 'required|numeric',
        ]);

        $store = Purchase::create([
            'nomor_pembelian' => $code,
            'account_detail_id' => $request->rincian_akun,
            'account_detail_payment_id' => $request->rincian_akun_pembayaran,
            'supplier_id' => $request->supplier,
            'tanggal' => $request->tanggal,
            'total' => $request->total,
            'keterangan' => 'Pembelian barang',
        ]);

        for($i = 0; $i < count((array) $request->kuantitas); $i++)
        {
            $currentStok = Item::select('stok')->where('id', $request->barang[$i])->first();

            $storeDetail = PurchaseDetail::create([
                'purchase_id' => $number,
                'item_id' => $request->barang[$i],
                'kuantitas'  => $request->kuantitas[$i],
                'harga_satuan' => $request->harga_satuan[$i],
                'subtotal' => $request->subtotal[$i],
            ]);

            $storeStok = Item::where('id', $request->barang[$i])->update([
                'stok' => $currentStok->stok + $request->kuantitas[$i],
            ]);
        }

        if ($store && $storeDetail) {
            $statementGeneralEntry = DB::select("show table status like 'general_entries'");
            $numberGeneralEntry = $statementGeneralEntry[0]->Auto_increment;

            $storeGeneralEntry = GeneralEntry::create([
                'purchase_id' => $number,
                'nomor_transaksi' => $numberGeneralEntry,
                'tanggal' => $request->tanggal,
            ]);

            $storeGeneralEntryDetail = GeneralEntryDetail::create([
                'purchase_id' => $number,
                'account_detail_id' => $request->rincian_akun,
                'general_entry_id' => $numberGeneralEntry,
                'debit' => $request->total,
                'kredit' => 0,
            ]);

            $storeGeneralEntryDetail2 = GeneralEntryDetail::create([
                'purchase_id' => $number,
                'account_detail_id' => $request->rincian_akun_pembayaran,
                'general_entry_id' => $numberGeneralEntry,
                'debit' => 0,
                'kredit' => $request->total,
            ]);
        }
        return response()->json([$store, $storeDetail, $storeGeneralEntry, $storeGeneralEntryDetail, $storeGeneralEntryDetail2, $storeStok]);
    }

    public function show(Purchase $purchase)
    {
        $purchaseDetail = PurchaseDetail::where('purchase_id', $purchase->id)->get();
        $response = "<div class='table-responsive'>";
            $response .= "<table class='display table table-striped table-hover'>";
                $response .= "<thead>";
                    $response .= "<tr>";
                        $response .= "<th>Barang</th>";
                        $response .= "<th>Kuantitas</th>";
                        $response .= "<th>Harga Satuan</th>";
                        $response .= "<th>Subtotal</th>";
                        $response .= "<th>Action</th>";
                    $response .= "</tr>";
                $response .= "</thead>";
                $response .= "<tbody>";
                foreach ($purchaseDetail as $pDetail) {
                    $response .= "<tr>";
                        $response .= "<td>".$pDetail->item->nama."</td>";
                        $response .= "<td>".$pDetail->kuantitas." pcs</td>";
                        $response .= "<td>Rp".number_format($pDetail->harga_satuan, 0, '', '.').",-</td>";
                        $response .= "<td>Rp".number_format($pDetail->subtotal, 0, '', '.').",-</td>";
                        $response .= '<td><div class="form-button-action"><button type="button" name="editDetail" data-toggle="tooltip" data-id="'.$pDetail->id.'" id="'.$pDetail->purchase_id.'" data-original-title="EditDetail" class="editDetail btn btn-primary btn-sm">Edit</button>';
                        $response .= '&nbsp;&nbsp;&nbsp;<button type="button" name="deleteDetail" data-id="'.$pDetail->purchase_id.'" id="'.$pDetail->id.'" class="deleteDetail btn btn-danger btn-sm">Delete</button></div></td>';
                    $response .= "</tr>";
                }
                $response .= "</tbody>";
            $response .= "</table>";
        $response .= "</div>";
        echo $response;
    }

    public function edit(Purchase $purchase)
    {
        if(request()->ajax()) {
            $edit = Purchase::findOrFail($purchase->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'rincian_akun' => 'required|numeric|exists:account_details,id',
            'rincian_akun_pembayaran' => 'required|numeric|exists:account_details,id',
            'supplier' => 'required|numeric|exists:suppliers,id',
            'tanggal' => 'required|date',
        ]);

        $update = Purchase::where('id', $request->id)->update([
            'account_detail_id' => $request->rincian_akun,
            'account_detail_payment_id' => $request->rincian_akun_pembayaran,
            'supplier_id' => $request->supplier,
            'tanggal' => $request->tanggal,
        ]);

        if ($update) {
            $updateGeneralEntry = GeneralEntry::where('purchase_id', $request->id)->update([
                'tanggal' => $request->tanggal,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $request->id)->where('kredit', 0)->update([
                'account_detail_id' => $request->rincian_akun,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('purchase_id', $request->id)->where('debit', 0)->update([
                'account_detail_id' => $request->rincian_akun_pembayaran,
            ]);
        }

        return response()->json([$update, $updateGeneralEntry, $updateGeneralEntryDetail]);
    }

    public function destroy(Purchase $purchase)
    {
        $destroy = Purchase::where('id', $purchase->id)->delete();
        return response()->json($destroy);
    }

    public function getBarang()
    {
        $barang = Item::select('id', 'nama')->get();
        if($barang != null){
            return response()->json($barang);
        }
    }

    public function getBarangById(Item $item)
    {
        if(request()->ajax()) {
            $getBarang = Item::findOrFail($item->id);
            return response()->json($getBarang);
        }
    }

    public function getServis()
    {
        $servis = Service::select('id', 'nama')->get();
        if($servis != null){
            return response()->json($servis);
        }
    }

    public function getServisById(Service $service)
    {
        if(request()->ajax()) {
            $getServis = Service::findOrFail($service->id);
            return response()->json($getServis);
        }
    }
}
