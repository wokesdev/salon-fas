<?php

namespace App\Http\Controllers;

use App\Models\AccountDetail;
use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountDetailController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::select('id', 'nomor_akun', 'nama_akun')->orderBy('nomor_akun', 'ASC')->get();
        if ($request->ajax()) {
            $accountDetail = AccountDetail::query()->with('account');
            return DataTables::of($accountDetail)
                ->addColumn('action', function($accountDetail) {
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$accountDetail->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$accountDetail->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.account-detail.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'akun_id' => 'required|numeric|exists:accounts,id',
            'nama_rincian_akun' => 'required|string|max:255|unique:account_details,nama_rincian_akun',
        ]);

        $akun_id = $request->akun_id;
        $nomor_akun = Account::select('nomor_akun')->where('id', $akun_id)->first();
        $nomor_rincian_akun = AccountDetail::where('account_id', $akun_id)->pluck('nomor_rincian_akun')->toArray();
        $other_nomor_akun = Account::select('nomor_akun')->where('nomor_akun', '!=', $nomor_akun->nomor_akun)->where('nomor_akun', '>', $nomor_akun->nomor_akun)->orderBy('nomor_akun', 'asc')->first();

        if ($other_nomor_akun != null) {
            for ($i = $nomor_akun->nomor_akun + 1; $i < $other_nomor_akun->nomor_akun; $i++) {
                if(!in_array($i, $nomor_rincian_akun)){
                    $store = AccountDetail::create([
                        'account_id' => $request->akun_id,
                        'nomor_rincian_akun' => $i,
                        'nama_rincian_akun' => $request->nama_rincian_akun,
                    ]);
                    return response()->json($store);
                    break;
                }
            }
        } else {
            for ($i = $nomor_akun->nomor_akun + 1; $i < 9999; $i++) {
                if(!in_array($i, $nomor_rincian_akun)){
                    $store = AccountDetail::create([
                        'account_id' => $request->akun_id,
                        'nomor_rincian_akun' => $i,
                        'nama_rincian_akun' => $request->nama_rincian_akun,
                    ]);
                    return response()->json($store);
                    break;
                }
            }
        }
    }

    public function edit(AccountDetail $accountDetail)
    {
        if(request()->ajax()) {
            $edit = AccountDetail::findOrFail($accountDetail->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, AccountDetail $accountDetail)
    {
        $request->validate([
            'nama_rincian_akun' => 'required|string|max:255|unique:account_details,nama_rincian_akun,' . $request->id,
        ]);

        $edit = AccountDetail::where('id', $request->id)->update([
            'nama_rincian_akun' => $request->nama_rincian_akun,
        ]);
        return response()->json($edit);
    }

    public function destroy(AccountDetail $accountDetail)
    {
        $destroy = AccountDetail::where('id', $accountDetail->id)->delete();
        return response()->json($destroy);
    }
}
