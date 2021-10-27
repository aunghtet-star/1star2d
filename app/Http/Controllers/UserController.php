<?php

namespace App\Http\Controllers;

use App\Two;
use App\User;
use App\Three;
use Carbon\Carbon;
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
            $edit_icon = '<a href="'.url('/admin/users/'.$each->id.'/edit').'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
            $delete_icon = '<a href="'.url('/admin/users/'.$each->id).'" data-id="'.$each->id.'" class="text-danger" id="delete"><i class="fas fa-trash"></i></a>';
            $detail_icon = '<a href="'.url('/admin/users/'.$each->id).'"  data-id="'.$each->id.'" id="show" onclick="show()" ><i class="fas fa-eye"></i></a>';
            
            return '<div class="action-icon">'.$edit_icon . $delete_icon.$detail_icon.'</div>';
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

    public function show($id)
    {
        $user = User::findOrFail($id);
        $user_id = Two::where('user_id', $id)->first();

        return view('backend.users.detail', compact('user', 'user_id'));
    }
    
    public function userDetail(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user_id = Two::where('user_id', $id)->first();

        $date = $request->date;
        $time = $request->time;
        
        if ($time == 'all') {
            $twototals = Two::where('user_id', $user->user_id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $twousers = Two::where('user_id', $user->user_id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
            
            $threetotals = Three::where('user_id', $user->user_id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $threeusers = Three::where('user_id', $user->user_id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }
        
        if ($time == 'true') {
            $twototals = Two::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
            $twousers = Two::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        
            $threetotals = Three::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->sum('amount');
            $threeusers = Three::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:00')])->get();
        }
        
        if ($time == 'false') {
            $twototals = Two::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $twousers = Two::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        
            $threetotals = Three::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->sum('amount');
            $threeusers = Three::where('user_id', $user->id)->whereDate('date', $date)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:00')])->get();
        }

        
        return view('backend.components.userdetail', compact('twousers', 'twototals', 'threeusers', 'threetotals'))->render();
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
