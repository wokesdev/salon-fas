<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::select('id', 'name', 'level')->get();
        if ($request->ajax()) {
            $users = User::query();
            return DataTables::of($users)
                ->addColumn('action', function($users) {
                    $button = '<div class="form-button-action"><button type="button" name="change-pass" data-id="'.$users->id.'" class="change-pass btn btn-warning btn-sm">Change Password</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" data-toggle="tooltip" data-id="'.$users->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="delete" id="'.$users->id.'" class="delete btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->editColumn('jabatan', function($users) {
                    if ($users->role_id == null) {
                        return null;
                    } else {
                        return $users->role->name;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master-data.admins.index', Compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|alpha_dash|unique:users,username',
            'email' => 'required|string|max:255|email|unique:users,email',
            'jabatan' => 'required|numeric|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $store = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->jabatan,
            'password' => Hash::make($request->password),
        ]);
        return response()->json($store);
    }

    public function edit(User $user)
    {
        if(request()->ajax()) {
            $edit = User::findOrFail($user->id);
            return response()->json($edit);
        }
    }

    public function update(Request $request, User $user)
    {
        if($request->action == 'Edit') {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|alpha_dash|unique:users,username,' . $request->id,
                'email' => 'required|string|max:255|email|unique:users,email,' . $request->id,
                'jabatan' => 'required|numeric|exists:roles,id',
            ]);

            $update = User::where('id', $request->id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role_id' => $request->jabatan,
            ]);
            return response()->json($update);
        }

        else if($request->action == 'ChangePass') {
            request()->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $updatePass = User::where('id', $request->id)->update([
                'password' => Hash::make($request->password),
            ]);
            return response()->json($updatePass);
        }
    }

    public function destroy(User $user)
    {
        $destroy = User::where('id', $user->id)->delete();
        return response()->json($destroy);
    }
}
