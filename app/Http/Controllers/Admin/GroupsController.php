<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupRequest;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = UserGroup::get();

        return view('admin.groups.index')->with(compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(GroupRequest $request)
    {
        UserGroup::create($this->_params($request));

        return redirect()->route('admin.user-groups.index');
    }

    public function edit(UserGroup $userGroup)
    {
        return view('admin.groups.edit')->with('model', $userGroup);
    }

    public function update(GroupRequest $request, UserGroup $userGroup)
    {
        $userGroup->update($this->_params($request));

        return redirect()->route('admin.user-groups.index');
    }

    public function show(UserGroup $userGroup)
    {
        return view('admin.groups.show')->with(compact('userGroup'));
    }

    public function destroy(UserGroup $userGroup)
    {
        $userGroup->users()->delete();
        $userGroup->delete();

        return redirect()->route('admin.user-groups.index');
    }

    public function _params($request, $overrides = [])
    {
        $requestParams = $request->only('name', 'discount', 'discount_type');
        return array_merge($requestParams, $overrides);
    }
}
