<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::query();
            return DataTables::of($supplier)
                ->addColumn('action', function($supplier){
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$supplier->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$supplier->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.suppliers.index');
    }

    public function store(Request $request)
    {
        $statement = DB::select("show table status like 'suppliers'");
        $number = $statement[0]->Auto_increment;
        $code = 'SP' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:suppliers,email',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'required|string|max:500',
            'phone' => 'required|numeric|digits_between:1,50',
        ]);

        $store = Supplier::create([
            'code' => $code,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);
        return response()->json($store);
    }

    public function edit(Supplier $supplier)
    {
        if(request()->ajax()) {
            $edit = Supplier::findOrFail($supplier->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:suppliers,email,' . $request->id,
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'required|string|max:500',
            'phone' => 'required|numeric|digits_between:1,50',
        ]);

        $update = Supplier::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json($update);
    }

    public function destroy(Supplier $supplier)
    {
        $destroy = Supplier::where('id', $supplier->id)->delete();
        return response()->json($destroy);
    }
}
