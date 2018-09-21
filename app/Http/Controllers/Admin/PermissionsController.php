<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
class PermissionsController extends Controller
{
    public function index()
    {
        return view('admin.permissions.index', [
            'permissions' => Permission::all(),
        ]);
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        Permission::create(['name' => $request->name]);
        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }


    public function edit($id)
    {
        return view('admin.permissions.edit', [
            'permission' => Permission::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $permission              = Permission::findOrFail($id);
        $permission->name        = $request->name;
        $permission->save();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    public function destroy($id)
    {
        Permission::destroy($id);
        return redirect()->route('admin.permissions.index')->with('warning', 'Permission sucessfully deleted');

    }
}
