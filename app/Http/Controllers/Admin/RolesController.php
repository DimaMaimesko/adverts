<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesController extends Controller
{

    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::withCount('users')->get(),
        ]);
    }


    public function create()
    {
        $permissions = Permission::get();
        return view('admin.roles.create', [
            'permissions' => $permissions,
        ]);
    }


    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->roles);
        $role->save();
        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }


    public function edit($id)
    {
        $role        = Role::findOrFail($id);
        $role        = $role->findByName($role->name);
        $permissions = Permission::all();

        return view('admin.roles.edit', [
            'role'        => $role,
            'permissions' => $permissions,
        ]);
    }


    public function update(Request $request, $id)
    {
        $role         = Role::findOrFail($id);
        $role->name   = $request->name;
//        $role->active = $request->active;
        $role->save();
        $role->syncPermissions($request->roles);
        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }


    public function destroy($id)
    {
        Role::destroy($id);
        return redirect()->route('admin.roles.index')->with('warning', 'Role sucessfully deleted');

    }
}
