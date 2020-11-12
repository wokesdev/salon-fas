<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $account = Account::query();
            return DataTables::of($account)
                ->addColumn('action', function($account) {
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$account->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$account->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.accounts.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_akun' => 'required|numeric|digits_between:1,4|unique:accounts,nomor_akun',
            'nama_akun' => 'required|string|max:255|unique:accounts,nama_akun',
        ]);

        $store = Account::create([
            'nomor_akun' => $request->nomor_akun,
            'nama_akun' => $request->nama_akun,
        ]);
        return response()->json($store);
    }

    public function edit(Account $account)
    {
        if(request()->ajax()) {
            $edit = Account::findOrFail($account->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Account $account)
    {
        $request->validate([
            'nomor_akun' => 'required|numeric|digits_between:1,4|unique:accounts,nomor_akun,' . $request->id,
            'nama_akun' => 'required|string|max:255|unique:accounts,nama_akun,' . $request->id,
        ]);

        $update = Account::where('id', $request->id)->update([
            'nomor_akun' => $request->nomor_akun,
            'nama_akun' => $request->nama_akun,
        ]);
        return response()->json($update);
    }

    public function destroy(Account $account)
    {
        $destroy = Account::where('id', $account->id)->delete();
        return response()->json($destroy);
    }
}
