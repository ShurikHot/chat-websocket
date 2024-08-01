<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRoleToggleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Resources\Admin\UserRoleResource;
use App\Models\Admin\Role;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->with('roles')->get();
        $users = UserRoleResource::collection($users)->resolve();
        $roles = RoleResource::collection(Role::all())->resolve();

        return inertia('Admin/User/Index', compact('users', 'roles'));
    }

    public function toggleRole(UserRoleToggleRequest $request, User $user)
    {
        $data = $request->validated();
        $user->roles()->toggle($data);

        return UserRoleResource::make($user)->resolve();
    }
}
