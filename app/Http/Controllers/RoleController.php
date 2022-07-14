<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('admin.roles.index', ['roles'=>$roles]);
    }

    public function store(){
        request()->validate([
            'name' => 'required',
        ]);
        Role::create([
            'name' => Str::ucfirst(request('name')),
            'slug' => Str::of(Str::lower(request('slug')))->slug('-'),
        ]);
        return back();
        
    }

    public function destroy(Role $role){
        $role->delete();
        session()->flash('role-deleted', 'Deleted Role ' . $role->name);
        return back();
    }

    public function edit(Role $role){
        return view('admin.roles.edit', [
            'role'=>$role,
            'permissions'=>Permission::all(),
        ]);
    }

    public function update(Role $role){
        request()->validate([
            'name' => 'required',
        ]);
        $role->update([
            'name' => Str::ucfirst(request('name')),
            'slug' => Str::of(Str::lower(request('slug')))->slug('-'),
        ]);
        if($role->isDirty('name')){
            session()->flash('role-updated', 'Role Updated ' . $role->name);

            $role->save();
        }else{
            session()->flash('role-updated', 'Nothing to update');
        }
        return back();
    }

    public function attach_Permission(Role $role){

        $role->permissions()->attach(request('permissions'));

        return back();

    }

    public function detach_Permission(Role $role){

        $role->permissions()->detach(request('permissions'));

        return back();

    }
}
