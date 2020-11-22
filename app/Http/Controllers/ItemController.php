<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $item = Item::query();
            return DataTables::of($item)
                ->addColumn('action', function($item) {
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$item->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$item->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.item.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:items,nama',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $store = Item::create([
            'nama' => $request->nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
        ]);
        return response()->json($store);
    }

    public function edit(Item $item)
    {
        if(request()->ajax()) {
            $edit = Item::findOrFail($item->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:items,nama,' . $request->id,
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $update = Item::where('id', $request->id)->update([
            'nama' => $request->nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
        ]);
        return response()->json($update);
    }

    public function destroy(Item $item)
    {
        $destroy = Item::where('id', $item->id)->delete();
        return response()->json($destroy);
    }
}
