<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customer = Customer::query();
            return DataTables::of($customer)
                ->addColumn('action', function($customer){
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$customer->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$customer->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.customer.index');
    }

    public function store(Request $request)
    {
        $statement = DB::select("show table status like 'customers'");
        $number = $statement[0]->Auto_increment;
        $code = 'CS' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:customers,email',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|numeric|digits_between:1,50',
        ]);

        $store = Customer::create([
            'kode_pelanggan' => $code,
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
        return response()->json($store);
    }

    public function edit(Customer $customer)
    {
        if(request()->ajax()) {
            $edit = Customer::findOrFail($customer->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:customers,email,' . $request->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|numeric|digits_between:1,50',
        ]);

        $update = Customer::where('id', $request->id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
        return response()->json($update);
    }

    public function destroy(Customer $customer)
    {
        $destroy = Customer::where('id', $customer->id)->delete();
        return response()->json($destroy);
    }
}
