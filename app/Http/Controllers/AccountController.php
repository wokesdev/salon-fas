<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $account = Account::query();
            return DataTables::of($account)
                ->addColumn('action', function($account){
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$account->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$account->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('master-data.accounts.index');
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
        request()->validate([
            'no' => 'required|numeric|digits_between:1,4',
            'name' => 'required|string|max:255',
            'no_rincian' => 'required|numeric|digits_between:1,4',
            'name_rincian' => 'required|string|max:255',
        ]);

        $store = Account::create([
            'nomor_akun' => $request->no,
            'nama_akun' => $request->name,
            'nomor_rincian_akun' => $request->no_rincian,
            'nama_rincian_akun' => $request->name_rincian,
        ]);

        return response()->json($store);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        if(request()->ajax()) {
            $edit = Account::findOrFail($account->id);
            return response()->json($edit);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        request()->validate([
            'no' => 'required|numeric|digits_between:1,4',
            'name' => 'required|string|max:255',
            'no_rincian' => 'required|numeric|digits_between:1,4',
            'name_rincian' => 'required|string|max:255',
        ]);

        $update = Account::where('id', $request->id)->update([
            'nomor_akun' => $request->no,
            'nama_akun' => $request->name,
            'nomor_rincian_akun' => $request->no_rincian,
            'nama_rincian_akun' => $request->name_rincian,
        ]);

        return response()->json($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $destroy = Account::where('id', $account->id)->delete();
        return response()->json($destroy);
    }
}
