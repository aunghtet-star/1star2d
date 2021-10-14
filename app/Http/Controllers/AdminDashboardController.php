<?php

namespace App\Http\Controllers;

use App\User;
use App\AdminUser;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $adminusers = AdminUser::all();
        return view('backend.admin.index', compact('adminusers'));
    }

    public function ssd()
    {
        return Datatables::of(AdminUser::query())
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
           
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }
    
    public function create()
    {
        return view('backend.admin.create');
    }

    public function store(StoreAdminUser $request)
    {
        $adminusers = new AdminUser();
        $adminusers->name = $request->name;
        $adminusers->phone = $request->phone;
        $adminusers->email = $request->email;
        $adminusers->password = Hash::make($request->password);
        $adminusers->save();

        return redirect('/admin')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        $adminuser = AdminUser::findOrFail($id);
        return view('backend.admin.edit', compact('adminuser'));
    }

    public function update(UpdateAdminUser $request, $id)
    {
        $adminuser = AdminUser::findOrFail($id);

        $adminuser->name = $request->name;
        $adminuser->phone = $request->phone;
        $adminuser->email = $request->email;
        $adminuser->password = $request->password ? Hash::make($request->password) : $adminuser->password ;
        $adminuser->update();

        return redirect('/admin')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $adminuser = AdminUser::findOrFail($id);
        $adminuser->delete();

        return 'success';
    }
}
