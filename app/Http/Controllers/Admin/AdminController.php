<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('view-admins');
        $admins = User::whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['CUSTOMER', 'SELLER']);
        })->with('roles')->get();
        $roles = Role::whereNotIn('name', ['CUSTOMER', 'SELLER'])->get();
        return view('admin.admin.list', compact('admins', 'roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create-admins');

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $admin = new User;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->status = true;

        if ($request->hasFile('profile_picture')) {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            $image_path = $request->file('profile_picture')->store('admin', 'public');
            $admin->profile_picture = $image_path;
        }

        $admin->save();
        $admin->assignRole($request->role);

        return redirect()->route('admin.index')->with('message', 'Admin has been added successfully');
    }

    public function edit($id)
    {
        $this->authorize('edit-admins');
        $admin = User::with('roles')->where('id', $id)->first();
        $roles = Role::whereNotIn('name', ['CUSTOMER', 'SELLER'])->get();
        return response()->json([
            'admin' => $admin,
            'roles' => $roles,
            'message' => 'Admin details found successfully.'
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('edit-admins');

        $request->validate([
            'edit_name' => 'required',
            'edit_email' => 'required|email|unique:users,email,' . $request->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->edit_name;
        $user->email = $request->edit_email;

        if ($request->hasFile('profile_picture')) {
            $image_path = $request->file('profile_picture')->store('user', 'public');
            $user->profile_picture = $image_path;
        }

        $user->save();
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('message', 'Admin account has been successfully updated.');
    }

    public function delete($id)
    {
        $this->authorize('delete-admins');
        $user = User::findOrFail($id);

        if ($user->hasRole('ADMIN') && User::role('ADMIN')->count() <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the last admin user!');
        }

        $user->delete();
        return redirect()->back()->with('error', 'Admin has been deleted!');
    }
}
