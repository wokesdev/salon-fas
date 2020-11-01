<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $package = Package::query();
            return DataTables::of($package)
                ->addColumn('action', function($package){
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$package->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$package->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('master-data.paket.index');
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
        $request->harga = str_replace('.', '', $request->harga);

        request()->validate([
            'name' => 'required|string|max:255|unique:packages,name',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        $store = Package::create([
            'name' => $request->name,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
        ]);

        return response()->json($store);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        if(request()->ajax()) {
            $edit = Package::findOrFail($package->id);
            return response()->json($edit);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        request()->validate([
            'name' => 'required|string|max:255|unique:packages,name,' . $request->id,
            'kategori' => 'required|string|max:255',
            'harga' => 'required|numeric|digits_between:1,9',
        ]);

        $update = Package::where('id', $request->id)->update([
            'name' => $request->name,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
        ]);

        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $destroy = Package::where('id', $package->id)->delete();
        return response()->json($destroy);
    }
}
