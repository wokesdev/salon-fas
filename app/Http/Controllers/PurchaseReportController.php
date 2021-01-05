<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PurchaseReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
                if ($request->from_date === $request->to_date) {
                    $from_date = $request->from_date;
                    $purchases = Purchase::query()->with('supplier')->whereDate('tanggal', '=', $from_date)->get();
                }

                else {
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;
                    $purchases = Purchase::query()->with('supplier')->whereBetween('tanggal', array($from_date, $to_date))->get();
                }
            }

            else {
                $purchases = Purchase::query()->with('supplier')->get();
            }

            return DataTables::of($purchases)->make(true);
        }
        return view('laporan.laporan-pembelian.index');
    }
}
