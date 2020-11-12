<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\AccountDetail;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->get();
        $suppliers = Supplier::select('id', 'code', 'name')->get();
        if ($request->ajax()) {
            $purchase = Purchase::query();
            return DataTables::of($purchase)
                ->addColumn('action', function($purchase) {
                    $button = '<div class="form-button-action"><button type="button" name="detail" data-toggle="tooltip" data-id="'.$purchase->id.'" data-original-title="Detail" class="detail btn btn-warning btn-sm">Detail</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" data-toggle="tooltip" data-id="'.$purchase->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$purchase->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->editColumn('kode_supplier', function($purchase) {
                    if ($purchase->supplier_id == null) {
                        return null;
                    } else {
                        return $purchase->supplier->code;
                    }
                })
                ->editColumn('nama_supplier', function($purchase) {
                    if ($purchase->supplier_id == null) {
                        return null;
                    } else {
                        return $purchase->supplier->name;
                    }
                })
                ->editColumn('nomor_rincian_akun', function($purchase) {
                    if ($purchase->account_detail_id == null) {
                        return null;
                    } else {
                        return $purchase->account_detail->nomor_rincian_akun;
                    }
                })
                ->editColumn('nama_rincian_akun', function($purchase) {
                    if ($purchase->account_detail_id == null) {
                        return null;
                    } else {
                        return $purchase->account_detail->nama_rincian_akun;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.purchases.index', compact('accountDetails', 'suppliers'));
    }

    public function store(Request $request)
    {
        $statement = DB::select("show table status like 'purchases'");
        $number = $statement[0]->Auto_increment;
        $code = 'PC' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $request->validate([
            'account_detail_id' => 'required|numeric|exists:account_details,id',
            'supplier_id' => 'required|numeric|exists:suppliers,id',
            'tanggal' => 'required|date',
            'kuantitas.*' => 'required|numeric',
            'harga_satuan.*' => 'required|numeric',
            'keterangan.*' => 'required|string|max:500',
        ]);

        $store = Purchase::create([
            'nomor_pembelian' => $code,
            'account_detail_id' => $request->account_detail_id,
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
        ]);

        for($i = 0; $i < count((array) $request->kuantitas); $i++)
        {
            $storeDetail = PurchaseDetail::create([
                'purchase_id' => $number,
                'kuantitas'  => $request->kuantitas[$i],
                'harga_satuan' => $request->price[$i],
                'total' => $request->kuantitas[$i] * $request->price[$i],
                'keterangan' => $request->keterangan[$i],
            ]);
        }
        return response()->json([$store, $storeDetail]);
    }

    public function show(Purchase $purchase)
    {
        $purchaseDetail = PurchaseDetail::where('purchase_id', $purchase->id)->get();
        $response = "<div class='table-responsive'>";
            $response .= "<table class='display table table-striped table-hover'>";
                $response .= "<thead>";
                    $response .= "<tr>";
                        $response .= "<th>Kuantitas</th>";
                        $response .= "<th>Harga Satuan</th>";
                        $response .= "<th>Total</th>";
                        $response .= "<th>Detail Keterangan</th>";
                        $response .= "<th>Action</th>";
                    $response .= "</tr>";
                $response .= "</thead>";
                $response .= "<tbody>";
                foreach ($purchaseDetail as $pDetail) {
                    $response .= "<tr>";
                        $response .= "<td>".$pDetail->kuantitas." pcs</td>";
                        $response .= "<td>Rp".number_format($pDetail->harga_satuan,2,',','.')."</td>";
                        $response .= "<td>Rp".number_format($pDetail->total,2,',','.')."</td>";
                        $response .= "<td>".$pDetail->keterangan."</td>";
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
            'account_detail_id' => 'required|numeric|exists:account_details,id',
            'supplier_id' => 'required|numeric|exists:suppliers,id',
            'tanggal' => 'required|date',
        ]);

        $update = Purchase::where('id', $request->id)->update([
            'account_detail_id' => $request->account_detail_id,
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
        ]);
        return response()->json($update);
    }

    public function destroy(Purchase $purchase)
    {
        $destroy = Purchase::where('id', $purchase->id)->delete();
        return response()->json($destroy);
    }
}
