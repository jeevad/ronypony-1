<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\UserGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['role', 'group'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleOptions = Role::getRoleOptions();
        $groupOptions = UserGroup::getGroupOptions();

        return view('admin.users.create')->with(compact('roleOptions'))->with(compact('groupOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Admin\UserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create($this->_params($request));

        return redirect()->route('admin.users.index');
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->with('model', $user)
            ->with('roleOptions', Role::getRoleOptions())
            ->with('groupOptions', UserGroup::getGroupOptions());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \AvoRed\Framework\Http\Requests\AdminUserRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($this->_params($request));

        return redirect()->route('admin.users.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show')->with(compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function _params($request, $overrides = [])
    {
        $requestParams = $request->only('full_name', 'email', 'mobile_number', 'role_id', 'group_id');
        return array_merge($requestParams, $overrides);
    }
}