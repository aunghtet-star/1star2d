<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('backend.users.index', compact('users'));
    }

    public function ssd()
    {
        return Datatables::of(User::query())
        ->addColumn('action', function ($each) {
            $edit_icon = '<a href="'.url('admin/users/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('admin/users/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            
           
            return '<div class="action-icon">'.$edit_icon . $delete_icon.'</div>';
        })
        ->make(true);
    }
    
    public function create()
    {
        return view('backend.users.create');
    }

    public function store(StoreUser $request)
    {
        $users = new User();
        $users->name = $request->name;
        $users->phone = $request->phone;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();

        return redirect('admin/users')->with('create', 'Created Successfully');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(UpdateUser $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = $request->password ? Hash::make($request->password) : $user->password ;
        $user->update();

        return redirect('admin/users')->with('update', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return 'success';
    }
}
