<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\AccountDetail;
use App\Models\GeneralEntry;
use App\Models\GeneralEntryDetail;
use App\Models\SaleDetail;
use App\Models\Item;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $accountDetails = AccountDetail::select('id', 'nomor_rincian_akun', 'nama_rincian_akun')->orderBy('nomor_rincian_akun', 'ASC')->get();
        $customers = Customer::select('id', 'kode_pelanggan', 'nama')->orderBy('kode_pelanggan', 'ASC')->get();
        $items = Item::select('id', 'nama')->orderBy('nama', 'ASC')->get();
        $services = Service::select('id', 'nama')->orderBy('nama', 'ASC')->get();
        if ($request->ajax()) {
            $sale = Sale::query()->with(['customer', 'account_detail']);
            return DataTables::of($sale)
                ->addColumn('action', function($sale) {
                    $button = '<div class="form-button-action"><button type="button" name="detail" data-toggle="tooltip" data-id="'.$sale->id.'" data-original-title="Detail" class="detail btn btn-warning btn-sm">Detail</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" data-toggle="tooltip" data-id="'.$sale->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$sale->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.sale.index', compact('accountDetails', 'customers', 'items', 'services'));
    }

    public function store(Request $request)
    {
        $statement = DB::select("show table status like 'sales'");
        $number = $statement[0]->Auto_increment;
        $code = 'SL' . str_pad($number, 5, '0', STR_PAD_LEFT);

        if (count((array) $request->servis) > 0 && count((array) $request->barang) > 0) {
            $request->validate([
                'rincian_akun' => 'required|numeric|exists:account_details,id',
                'rincian_akun_pembayaran' => 'required|numeric|exists:account_details,id',
                'customer' => 'required|numeric|exists:customers,id',
                'tanggal' => 'required|date',
                'total_barang' => 'required|numeric',
                'total_servis' => 'required|numeric',
                'total' => 'required|numeric',
                'barang.*' => 'required|numeric|exists:items,id',
                'kuantitas.*' => 'required|numeric',
                'harga_satuan.*' => 'required|numeric',
                'subtotal.*' => 'required|numeric',
                'servis.*' => 'required|numeric|exists:services,id',
                'kuantitas_servis.*' => 'required|numeric',
                'harga_satuan_servis.*' => 'required|numeric',
                'subtotal_servis.*' => 'required|numeric',
            ]);

            $store = Sale::create([
                'nomor_penjualan' => $code,
                'account_detail_id' => $request->rincian_akun,
                'account_detail_payment_id' => $request->rincian_akun_pembayaran,
                'customer_id' => $request->customer,
                'tanggal' => $request->tanggal,
                'total_barang' => $request->total_barang,
                'total_servis' => $request->total_servis,
                'total' => $request->total_barang + $request->total_servis,
                'keterangan' => 'Penjualan barang atau jasa',
            ]);

            for($i = 0; $i < count((array) $request->servis); $i++)
            {
                $currentStok = Item::select('stok')->where('id', $request->barang[$i])->first();

                $storeDetail = SaleDetail::create([
                    'sale_id' => $number,
                    'item_id' => $request->barang[$i],
                    'kuantitas_barang'  => $request->kuantitas[$i],
                    'harga_satuan_barang' => $request->harga_satuan[$i],
                    'subtotal_barang' => $request->subtotal[$i],
                    'service_id' => $request->servis[$i],
                    'kuantitas_servis'  => $request->kuantitas_servis[$i],
                    'harga_satuan_servis' => $request->harga_satuan_servis[$i],
                    'subtotal_servis' => $request->subtotal_servis[$i],
                ]);

                $storeStok = Item::where('id', $request->barang[$i])->update([
                    'stok' => $currentStok->stok - $request->kuantitas[$i],
                ]);
            }
        }

        elseif (count((array) $request->servis) > 0) {
            $request->validate([
                'rincian_akun' => 'required|numeric|exists:account_details,id',
                'rincian_akun_pembayaran' => 'required|numeric|exists:account_details,id',
                'customer' => 'required|numeric|exists:customers,id',
                'tanggal' => 'required|date',
                'total_servis' => 'required|numeric',
                'servis.*' => 'required|numeric|exists:services,id',
                'kuantitas_servis.*' => 'required|numeric',
                'harga_satuan_servis.*' => 'required|numeric',
                'subtotal_servis.*' => 'required|numeric',
            ]);

            $store = Sale::create([
                'nomor_penjualan' => $code,
                'account_detail_id' => $request->rincian_akun,
                'account_detail_payment_id' => $request->rincian_akun_pembayaran,
                'customer_id' => $request->customer,
                'tanggal' => $request->tanggal,
                'total_servis' => $request->total_servis,
                'total' => $request->total_servis,
                'keterangan' => 'Penjualan barang atau jasa',
            ]);

            for($i = 0; $i < count((array) $request->servis); $i++)
            {
                $storeDetail = SaleDetail::create([
                    'sale_id' => $number,
                    'service_id' => $request->servis[$i],
                    'kuantitas_servis'  => $request->kuantitas_servis[$i],
                    'harga_satuan_servis' => $request->harga_satuan_servis[$i],
                    'subtotal_servis' => $request->subtotal_servis[$i],
                ]);
            }

            $storeStok = null;
        }

        elseif (count((array) $request->barang) > 0) {
            $request->validate([
                'rincian_akun' => 'required|numeric|exists:account_details,id',
                'rincian_akun_pembayaran' => 'required|numeric|exists:account_details,id',
                'customer' => 'required|numeric|exists:customers,id',
                'tanggal' => 'required|date',
                'total_barang' => 'required|numeric',
                'barang.*' => 'required|numeric|exists:items,id',
                'kuantitas.*' => 'required|numeric',
                'harga_satuan.*' => 'required|numeric',
                'subtotal.*' => 'required|numeric',
            ]);

            $store = Sale::create([
                'nomor_penjualan' => $code,
                'account_detail_id' => $request->rincian_akun,
                'account_detail_payment_id' => $request->rincian_akun_pembayaran,
                'customer_id' => $request->customer,
                'tanggal' => $request->tanggal,
                'total_barang' => $request->total_barang,
                'total' => $request->total_barang,
                'keterangan' => 'Penjualan barang atau jasa',
            ]);

            for($i = 0; $i < count((array) $request->barang); $i++)
            {
                $currentStok = Item::select('stok')->where('id', $request->barang[$i])->first();

                $storeDetail = SaleDetail::create([
                    'sale_id' => $number,
                    'item_id' => $request->barang[$i],
                    'kuantitas_barang'  => $request->kuantitas[$i],
                    'harga_satuan_barang' => $request->harga_satuan[$i],
                    'subtotal_barang' => $request->subtotal[$i],
                ]);

                $storeStok = Item::where('id', $request->barang[$i])->update([
                    'stok' => $currentStok->stok - $request->kuantitas[$i],
                ]);
            }
        }

        else {
            abort(422, 'Mohon mengisi data penjualan servis atau barang!');
        }

        if ($store && $storeDetail) {
            $statementGeneralEntry = DB::select("show table status like 'general_entries'");
            $numberGeneralEntry = $statementGeneralEntry[0]->Auto_increment;

            $storeGeneralEntry = GeneralEntry::create([
                'sale_id' => $number,
                'nomor_transaksi' => $numberGeneralEntry,
                'tanggal' => $request->tanggal,
            ]);

            if ($request->total !== null) {
                $total = $request->total;
            }

            elseif ($request->total === null) {
                if ($request->total_servis !== null) {
                    $total = $request->total_servis;
                }

                else {
                    $total = $request->total_barang;
                }
            }

            $storeGeneralEntryDetail = GeneralEntryDetail::create([
                'sale_id' => $number,
                'account_detail_id' => $request->rincian_akun_pembayaran,
                'general_entry_id' => $numberGeneralEntry,
                'debit' => $total,
                'kredit' => 0,
            ]);

            $storeGeneralEntryDetail = GeneralEntryDetail::create([
                'sale_id' => $number,
                'account_detail_id' => $request->rincian_akun,
                'general_entry_id' => $numberGeneralEntry,
                'debit' => 0,
                'kredit' => $total,
            ]);
        }
        return response()->json([$store, $storeDetail, $storeGeneralEntry, $storeGeneralEntryDetail, $storeStok]);
    }

    public function show(Sale $sale)
    {
        $saleDetail = SaleDetail::where('sale_id', $sale->id)->get();
        $response = "<div class='table-responsive'>";
            $response .= "<table class='display table table-striped table-hover'>";
                $response .= "<thead>";
                    $response .= "<tr>";
                        $response .= "<th>Servis</th>";
                        $response .= "<th>Kuantitas Servis</th>";
                        $response .= "<th>Harga Satuan Servis</th>";
                        $response .= "<th>Subtotal Servis</th>";
                        $response .= "<th>Barang</th>";
                        $response .= "<th>Kuantitas Barang</th>";
                        $response .= "<th>Harga Satuan Barang</th>";
                        $response .= "<th>Subtotal Barang</th>";
                        $response .= "<th>Action</th>";
                    $response .= "</tr>";
                $response .= "</thead>";
                $response .= "<tbody>";
                foreach ($saleDetail as $sDetail) {
                    $response .= "<tr>";
                        if ($sDetail->service_id != null && $sDetail->item_id != null) {
                            $response .= "<td>".$sDetail->service->nama."</td>";
                            $response .= "<td>".$sDetail->kuantitas_servis." kali</td>";
                            $response .= "<td>Rp".number_format($sDetail->harga_satuan_servis, 0, '', '.').",-</td>";
                            $response .= "<td>Rp".number_format($sDetail->subtotal_servis, 0, '', '.').",-</td>";
                            $response .= "<td>".$sDetail->item->nama."</td>";
                            $response .= "<td>".$sDetail->kuantitas_barang." pcs</td>";
                            $response .= "<td>Rp".number_format($sDetail->harga_satuan_barang, 0, '', '.').",-</td>";
                            $response .= "<td>Rp".number_format($sDetail->subtotal_barang, 0, '', '.').",-</td>";
                        }

                        elseif ($sDetail->service_id != null) {
                            $response .= "<td>".$sDetail->service->nama."</td>";
                            $response .= "<td>".$sDetail->kuantitas_servis." kali</td>";
                            $response .= "<td>Rp".number_format($sDetail->harga_satuan_servis, 0, '', '.').",-</td>";
                            $response .= "<td>Rp".number_format($sDetail->subtotal_servis, 0, '', '.').",-</td>";
                            $response .= "<td>-</td>";
                            $response .= "<td>-</td>";
                            $response .= "<td>-</td>";
                            $response .= "<td>-</td>";
                        }

                        elseif ($sDetail->item_id != null) {
                            $response .= "<td>-</td>";
                            $response .= "<td>-</td>";
                            $response .= "<td>-</td>";
                            $response .= "<td>-</td>";
                            $response .= "<td>".$sDetail->item->nama."</td>";
                            $response .= "<td>".$sDetail->kuantitas_barang." pcs</td>";
                            $response .= "<td>Rp".number_format($sDetail->harga_satuan_barang, 0, '', '.').",-</td>";
                            $response .= "<td>Rp".number_format($sDetail->subtotal_barang, 0, '', '.').",-</td>";
                        }

                        $response .= '<td><div class="form-button-action"><button type="button" name="editDetailServis" data-toggle="tooltip" data-id="'.$sDetail->id.'" id="'.$sDetail->sale_id.'" data-original-title="EditDetailServis" class="editDetailServis btn btn-primary btn-sm">Edit Servis</button>';
                        $response .= '&nbsp;&nbsp;&nbsp;<button type="button" name="editDetailBarang" data-toggle="tooltip" data-id="'.$sDetail->id.'" id="'.$sDetail->sale_id.'" data-original-title="EditDetailBarang" class="editDetailBarang btn btn-primary btn-sm">Edit Barang</button>';
                        $response .= '&nbsp;&nbsp;&nbsp;<button type="button" name="deleteDetail" data-id="'.$sDetail->sale_id.'" id="'.$sDetail->id.'" class="deleteDetail btn btn-danger btn-sm">Delete</button></div></td>';
                    $response .= "</tr>";
                }
                $response .= "</tbody>";
            $response .= "</table>";
        $response .= "</div>";
        echo $response;
    }

    public function edit(Sale $sale)
    {
        if(request()->ajax()) {
            $edit = Sale::findOrFail($sale->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'rincian_akun' => 'required|numeric|exists:account_details,id',
            'rincian_akun_pembayaran' => 'required|numeric|exists:account_details,id',
            'customer' => 'required|numeric|exists:customers,id',
            'tanggal' => 'required|date',
        ]);

        $update = Sale::where('id', $request->id)->update([
            'account_detail_id' => $request->rincian_akun,
            'account_detail_payment_id' => $request->rincian_akun_pembayaran,
            'customer_id' => $request->customer,
            'tanggal' => $request->tanggal,
        ]);

        if ($update) {
            $updateGeneralEntry = GeneralEntry::where('sale_id', $request->id)->update([
                'tanggal' => $request->tanggal,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $request->id)->where('kredit', 0)->update([
                'account_detail_id' => $request->rincian_akun_pembayaran,
            ]);

            $updateGeneralEntryDetail = GeneralEntryDetail::where('sale_id', $request->id)->where('debit', 0)->update([
                'account_detail_id' => $request->rincian_akun,
            ]);
        }
        return response()->json([$update, $updateGeneralEntry, $updateGeneralEntryDetail]);
    }

    public function destroy(Sale $sale)
    {
        if (SaleDetail::where('sale_id', $sale->id)->count() !== 0) {
            $currentSaleDetailCount = SaleDetail::where('sale_id', $sale->id)->count();
            for ($i = 0; $i < $currentSaleDetailCount; $i++) {
                $currentSaleDetail = SaleDetail::select('id', 'item_id', 'kuantitas_barang')->where('sale_id', $sale->id)->first();
                $currentItem = Item::select('stok')->where('id', $currentSaleDetail->item_id)->first();

                $destroyStok = Item::where('id', $currentSaleDetail->item_id)->update([
                    'stok' => $currentItem->stok - $currentSaleDetail->kuantitas_barang,
                ]);

                $destroySaleDetail = SaleDetail::where('id', $currentSaleDetail->id)->delete();
            }

            if ($destroyStok && $destroySaleDetail) {
                $destroy = Sale::where('id', $sale->id)->delete();
            }
        } else if (SaleDetail::where('sale_id', $sale->id)->count() === 0) {
            $destroyStok = null;
            $destroySaleDetail = null;
            $destroy = Sale::where('id', $sale->id)->delete();
        }

        return response()->json([$destroy, $destroyStok, $destroySaleDetail]);
    }
}
