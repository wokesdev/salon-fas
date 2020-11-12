<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::query();
            return DataTables::of($roles)
                ->addColumn('action', function($roles) {
                    $button = '<div class="form-button-action"><button type="button" name="edit" data-toggle="tooltip" data-id="'.$roles->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$roles->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.roles.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255|unique:roles,name',
            'level' => 'required|numeric|digits:1',
        ]);

        $store = Role::create([
            'name' => $request->jabatan,
            'level' => $request->level,
        ]);
        return response()->json($store);
    }

    public function edit(Role $role)
    {
        if(request()->ajax()) {
            $edit = Role::findOrFail($role->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255|unique:roles,name,' . $request->id,
            'level' => 'required|numeric|digits:1',
        ]);

        $update = Role::where('id', $request->id)->update([
            'name' => $request->jabatan,
            'level' => $request->level,
        ]);
        return response()->json($update);
    }

    public function destroy(Role $role)
    {
        $destroy = Role::where('id', $role->id)->delete();
        return response()->json($destroy);
    }
}
