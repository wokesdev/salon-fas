<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\AccountDetail;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->get();
        $customers = Customer::select('id', 'code', 'name')->get();
        if ($request->ajax()) {
            $sale = Sale::query();
            return DataTables::of($sale)
                ->addColumn('action', function($sale){
                    $button = '<div class="form-button-action"><button type="button" name="detail" data-toggle="tooltip" data-id="'.$sale->id.'" data-original-title="Detail" class="detail btn btn-warning btn-sm">Detail</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" data-toggle="tooltip" data-id="'.$sale->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$sale->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->editColumn('nomor_rincian_akun', function($sale) {
                    return $sale->account_detail->nomor_rincian_akun;
                })
                ->editColumn('nama_rincian_akun', function($sale) {
                    return $sale->account_detail->nama_rincian_akun;
                })
                ->editColumn('kode_supplier', function($sale) {
                    return $sale->customer->code;
                })
                ->editColumn('nama_supplier', function($sale) {
                    return $sale->customer->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.sales.index', compact('accountDetails', 'customers'));
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
        $statement = DB::select("show table status like 'sales'");
        $number = $statement[0]->Auto_increment;
        $code = 'SL' . str_pad($number, 5, '0', STR_PAD_LEFT);

        request()->validate([
            'account_detail_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:500',
        ]);

        $store = Sale::create([
            'nomor_pembelian' => $code,
            'account_detail_id' => $request->account_detail_id,
            'customer_id' => $request->customer_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json($store);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $saleDetail = SaleDetail::where('sale_id', $sale->id)->get();
        $response = "<div class='table-responsive'>";
            $response .= "<table class='display table table-striped table-hover'>";
                $response .= "<thead>";
                    $response .= "<tr>";
                        $response .= "<th>Kuantitas</th>";
                        $response .= "<th>Harga Satuan</th>";
                        $response .= "<th>Total</th>";
                        $response .= "<th>Detail Keterangan</th>";
                    $response .= "</tr>";
                $response .= "</thead>";
                $response .= "<tbody>";
                foreach ($saleDetail as $pDetail) {
                    $response .= "<tr>";
                        $response .= "<td>".$pDetail->kuantitas." pcs</td>";
                        $response .= "<td>Rp".number_format($pDetail->harga_satuan,2,',','.')."</td>";
                        $response .= "<td>Rp".number_format($pDetail->total,2,',','.')."</td>";
                        $response .= "<td>".$pDetail->keterangan."</td>";
                    $response .= "</tr>";
                }
                $response .= "</tbody>";
            $response .= "</table>";
        $response .= "</div>";
        echo $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        if(request()->ajax()) {
            $edit = Sale::findOrFail($sale->id);
            return response()->json($edit);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        request()->validate([
            'account_detail_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:500',
        ]);

        $update = Sale::where('id', $request->id)->update([
            'account_detail_id' => $request->account_detail_id,
            'customer_id' => $request->customer_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $destroy = Sale::where('id', $sale->id)->delete();
        return response()->json($destroy);
    }
}
