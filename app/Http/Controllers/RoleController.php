<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateRole;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('backend.roles.index', compact('roles'));
    }

    public function ssd()
    {
        return Datatables::of(Role::query())
        ->addColumn('permission', function ($each) {
            $output = '';
            foreach ($each->permissions as $permission) {
                $output .= '<span class="badge badge-pill badge-primary p-1 m-1">'.$permission->name.'</span>';
            }
            return $output;
        })
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('/admin/roles/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('/admin/roles/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->rawColumns(['permission','action'])
        ->make(true);
    }
    
    public function create()
    {
        $permissions = Permission::all();
        return view('backend.roles.create', compact('permissions'));
    }

    public function store(StoreRole $request)
    {
        $roles = new Role();
        $roles->name = $request->name;
        $permissions = $request->permissions;
        $roles->givePermissionTo($permissions);

        $roles->save();
    
        return redirect('admin/roles')->with('create', 'Created Successfully');
    }
    
    
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $old_permissions = $role->permissions->pluck('name')->toArray();

        return view('backend.roles.edit', compact('role', 'permissions', 'old_permissions'));
    }

    public function update(UpdateRole $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->name = $request->name;
        $permissions = $request->permissions;
        
        $old_permissions = $role->permissions->pluck('name')->toArray();
        
        $role->revokePermissionTo($old_permissions);
        $role->givePermissionTo($permissions);
        
        $role->update();
        
        return redirect('admin/roles')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return 'success';
    }
}
