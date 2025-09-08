<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('view-roles');
        $roles = Role::whereNotIn('name', ['CUSTOMER', 'SELLER'])->with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('create-roles');
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[1] ?? 'general';
        });
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create-roles');

        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1',
        ]);

        $role = Role::create(['name' => strtoupper($request->name)]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('message', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $this->authorize('edit-roles');

        if (in_array($role->name, ['CUSTOMER', 'SELLER'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot edit system roles.');
        }

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[1] ?? 'general';
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('edit-roles');

        if (in_array($role->name, ['CUSTOMER', 'SELLER'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot edit system roles.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array|min:1',
        ]);

        $role->update(['name' => strtoupper($request->name)]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('message', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete-roles');

        if (in_array($role->name, ['ADMIN', 'CUSTOMER', 'SELLER'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete system roles.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role with assigned users.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('message', 'Role deleted successfully.');
    }
}
