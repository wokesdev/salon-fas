<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $service = Service::query();
            return DataTables::of($service)
                ->addColumn('action', function($service) {
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$service->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$service->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.service.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:services,nama',
            'harga' => 'required|numeric',
        ]);

        $store = Service::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);
        return response()->json($store);
    }

    public function edit(Service $service)
    {
        if(request()->ajax()) {
            $edit = Service::findOrFail($service->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:services,name,' . $request->id,
            'harga' => 'required|numeric',
        ]);

        $update = Service::where('id', $request->id)->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);
        return response()->json($update);
    }

    public function destroy(Service $service)
    {
        $destroy = Service::where('id', $service->id)->delete();
        return response()->json($destroy);
    }
}
