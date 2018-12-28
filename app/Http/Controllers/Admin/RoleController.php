<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::get();

        return view('admin.roles.index')->with(compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->only('name', 'slug'));

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit')->with('model', $role);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only('name', 'slug'));

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        return view('admin.roles.show')->with(compact('role'));
    }

    public function destroy(Role $role)
    {
        $role->users()->delete();
        $role->delete();

        return redirect()->route('admin.roles.index');
    }
}
