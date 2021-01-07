<?php

namespace App\Http\Controllers;

use App\Models\CashPayment;
use App\Models\CashReceipt;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardDataController extends Controller
{
    public function supplier(Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::whereDate('created_at', '=', date('Y-m-d'))->count();
            if($supplier != null){
                return response()->json($supplier);
            } else {
                return 0;
            }
        }
    }

    public function customer(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::whereDate('created_at', '=', date('Y-m-d'))->count();
            if($customers != null){
                return response()->json($customers);
            } else {
                return 0;
            }
        }
    }

    public function purchase(Request $request)
    {
        if ($request->ajax()) {
            $purchases = Purchase::whereDate('tanggal', '=', date("Y-m-d"))->count();
            if($purchases != null){
                return response()->json($purchases);
            } else {
                return 0;
            }
        }
    }

    public function sale(Request $request)
    {
        if ($request->ajax()) {
            $sales = Sale::whereDate('tanggal', '=', date("Y-m-d"))->count();
            if($sales != null){
                return response()->json($sales);
            } else {
                return 0;
            }
        }
    }

    public function cash_payment(Request $request)
    {
        if ($request->ajax()) {
            $cash_payment = CashPayment::whereDate('tanggal', '=', date("Y-m-d"))->count();
            if($cash_payment != null){
                return response()->json($cash_payment);
            } else {
                return 0;
            }
        }
    }

    public function cash_receipt(Request $request)
    {
        if ($request->ajax()) {
            $cash_receipt = CashReceipt::whereDate('tanggal', '=', date("Y-m-d"))->count();
            if($cash_receipt != null){
                return response()->json($cash_receipt);
            } else {
                return 0;
            }
        }
    }
}
