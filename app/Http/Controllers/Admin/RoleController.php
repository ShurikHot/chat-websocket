<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Resources\Forum\Branch\BranchResource;
use App\Http\Resources\Forum\Section\SectionResource;
use App\Models\Admin\Role;
use App\Models\Forum\Branch;
use App\Models\Forum\Section;
use http\Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        $roles = RoleResource::collection($roles)->resolve();

        return inertia('Admin/Roles/Index', compact('roles'));
    }

    public function create(){
        $sections = Section::all();
        $sections = SectionResource::collection($sections)->resolve();

        return inertia('Admin/Roles/Create', compact('sections'));
    }

    public function store(StoreRoleRequest $request){
        $data = $request->validated();

        $code = $this->roleCodePrepare($data);

        Role::query()->firstOrCreate([
            'title' => $data['title'],
            'code' => $code
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role){
        $sections = Section::all();
        $sections = SectionResource::collection($sections)->resolve();

        $role_data = explode('.', $role['code']);
        $role_data['id'] = $role['id'];

        return inertia('Admin/Roles/Edit', compact('sections', 'role_data'));
    }

    public function update(UpdateRoleRequest $request, Role $role){
        $data = $request->validated();

        $code = $this->roleCodePrepare($data);

        dd($data);

        $role->update([
            'title' => $data['title'],
            'code' => $code
        ]);

        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role){
        dd($role);
    }

    public function roleCodePrepare($data){
        return rtrim(implode('.',$data), '.');
    }
}
