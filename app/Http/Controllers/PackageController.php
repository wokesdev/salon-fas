<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $package = Package::query();
            return DataTables::of($package)
                ->addColumn('action', function($package) {
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$package->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$package->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.pakets.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255|in:Laki-laki,Perempuan',
            'price' => 'required|numeric',
        ]);

        $store = Package::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
        ]);
        return response()->json($store);
    }

    public function edit(Package $package)
    {
        if(request()->ajax()) {
            $edit = Package::findOrFail($package->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255|in:Laki-laki,Perempuan',
            'price' => 'required|numeric',
        ]);

        $update = Package::where('id', $request->id)->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
        ]);
        return response()->json($update);
    }

    public function destroy(Package $package)
    {
        $destroy = Package::where('id', $package->id)->delete();
        return response()->json($destroy);
    }
}
