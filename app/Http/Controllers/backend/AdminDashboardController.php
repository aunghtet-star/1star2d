<?php

namespace App\Http\Controllers\backend;

use App\User;
use Exception;

use App\Wallet;
use App\ShowHide;
use App\AdminUser;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use App\Http\Requests\StoreUser;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateUser;
use App\Helpers\PermissionChecker;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use App\Http\Controllers\backend\AdminDashboardController;

class AdminDashboardController extends Controller
{
    public function index()
    {
        PermissionChecker::CheckPermission('view_admin');
        $adminusers = AdminUser::all();
        return view('backend.admin.index', compact('adminusers'));
        
    }

    public function ssd()
    {
        return Datatables::of(AdminUser::role('Admin')->get())
        ->addColumn('role', function ($each) {
            $output = '';
            foreach ($each->roles as $role) {
                $output .= '<span class="badge badge-pill badge-primary">'.$role->name.'</span>';
            }
            return $output;
        })
        ->addColumn('action', function ($each) {
            PermissionChecker::CheckPermission('edit_admin');
            $edit_icon = '<a href="'.url('admin/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            

            // if (Auth()->user()->can('delete_admin')) {
            //     //$delete_icon = '<a href="'.url('admin/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            // } else {
            //     return abort(404);
            // }
           
            return '<div class="action-icon">'.$edit_icon .'</div>';
        })
        ->rawColumns(['role','action'])
        ->make(true);
    }
    
    public function create()
    {
            PermissionChecker::CheckPermission('create_admin');
            $roles = Role::all();
            return view('backend.admin.create', compact('roles'));
    }

    public function store(StoreAdminUser $request)
    {
        return $request->all();
        DB::beginTransaction();
        try {
            $adminusers = new AdminUser();
            $adminusers->name = $request->name;
            $adminusers->phone = $request->phone;
            $roles = $request->roles;
            $adminusers->assignRole($roles);

            $adminusers->password = Hash::make($request->password);
            $adminusers->save();

            Wallet::firstOrCreate([
                'user_id' => $adminusers->id
            ], [
                'admin_user_id' => $adminusers->id,
                'account_numbers' => UUIDGenerator::AccountNumber(),
                'amount' => 0,
                'status' => 'admin'
            ]);

            DB::commit();
            return redirect('/admin')->with('create', 'Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/create')->withErrors(['fail' => 'something wrong'.$e->getMessage()]);
        }
    }

    public function edit($id)
    {
            PermissionChecker::CheckPermission('edit_admin');
            $adminuser = AdminUser::findOrFail($id);
            $roles = Role::all();
            $old_roles = $adminuser->roles->pluck('name')->toArray();
            return view('backend.admin.edit', compact('adminuser', 'roles', 'old_roles'));
        
    }

    public function update(UpdateAdminUser $request, $id)
    {
        DB::beginTransaction();

        try {
            $adminuser = AdminUser::findOrFail($id);

            $adminuser->name = $request->name;
            $adminuser->phone = $request->phone;
    
            $adminuser->syncRoles($request->roles);
            $adminuser->password = $request->password ? Hash::make($request->password) : $adminuser->password ;
            $adminuser->update();
            
            Wallet::firstOrCreate([
                'user_id' => $adminuser->id
            ], [
                'admin_user_id' => $adminuser->id,
                'account_numbers' => UUIDGenerator::AccountNumber(),
                'amount' => 0,
                'status' => 'admin'
            ]);
            DB::commit();
            return redirect('/admin')->with('update', 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/create')->withErrors(['fail'=>'something wrong'.$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $adminuser = AdminUser::findOrFail($id);
        $adminuser->delete();

        return 'success';
    }
}
