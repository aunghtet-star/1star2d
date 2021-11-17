<?php

namespace App\Http\Controllers;

use App\Two;
use App\User;
use App\Three;
use Exception;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use App\Http\Requests\StoreUser;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('admin_user_id', Auth()->user()->id)->get();
        
        return view('backend.users.index', compact('users'));
    }

    public function ssd()
    {
        $users = User::where('admin_user_id', Auth()->user()->id)->get();
        return Datatables::of($users)
        
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
        DB::beginTransaction();

        try {
            $users = new User();
            $users->name = $request->name;
            $users->admin_user_id = Auth::guard('adminuser')->user()->id;
            $users->phone = $request->phone;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);
            $users->save();
    
            Wallet::firstorCreate(
                [
                'user_id' => $users->id
                ],
                [
                'admin_user_id' => Auth::guard('adminuser')->user()->id,
                'account_numbers' => UUIDGenerator::AccountNumber(),
                'amount' => 0,
                'status' => 'user'
                ]
            );



            DB::commit();

            return redirect('admin/users')->with('create', 'Created Successfully');
        } catch (Exception $e) {
            DB::rollBack();

            return back()->withErrors(['fail' => 'something wrong'.$e->getMessage()])->withInput();
        }
    }

    public function show($id, Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');
        $user = User::findOrFail($id);

        //Wallet
        $user_wallet = Wallet::where('user_id', $user->id)->first();
        
        //Transaction History
        $user_transactions = Transaction::where('user_id', $user->id)->whereDate('created_at', $date. ' '.'00:00:00')->orderBy('created_at', 'DESC')->get();
        
        //Two Total AM And PM
        $two_users_am = Two::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')]);
        $two_users_pm = Two::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')]);

        $two_users_am_sum = Two::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')])->sum('amount');
        $two_users_pm_sum = Two::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')])->sum('amount');
        
        //Three Total AM And PM
        $three_users_am = Three::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')]);
        $three_users_pm = Three::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')]);

        $three_users_am_sum = Three::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'00:00:00'),Carbon::parse($date.' '.'11:59:59')])->sum('amount');
        $three_users_pm_sum = Three::where('user_id', $user->id)->where('admin_user_id', Auth()->user()->id)->whereBetween('created_at', [Carbon::parse($date.' '.'12:00:00'),Carbon::parse($date.' '.'23:59:59')])->sum('amount');

        if ($date) {
            $two_users_am = $two_users_am->whereDate('date', $date);
            $two_users_pm = $two_users_pm->whereDate('date', $date);

            $three_users_am = $three_users_am->whereDate('date', $date);
            $three_users_pm = $three_users_pm->whereDate('date', $date);
        }

        $two_users_am = $two_users_am->get();
        $two_users_pm = $two_users_pm->get();
        
        $three_users_am = $three_users_am->get();
        $three_users_pm = $three_users_pm->get();
        
        return view('backend.users.detail', compact('user', 'two_users_am', 'two_users_pm', 'two_users_am_sum', 'two_users_pm_sum', 'three_users_am', 'three_users_pm', 'three_users_am_sum', 'three_users_pm_sum', 'user_wallet', 'user_transactions'));
    }
    
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(UpdateUser $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->admin_user_id = Auth::guard('adminuser')->user()->id;
            $user->email = $request->email;
            $user->password = $request->password ? Hash::make($request->password) : $user->password ;
            $user->update();
        
        
            Wallet::firstorCreate(
                [
                'user_id' => $user->id
            ],
                [
                'admin_user_id' => Auth::guard('adminuser')->user()->id,
                'account_numbers' => UUIDGenerator::AccountNumber(),
                'amount' => 0,
                'status' => 'user'
            ]
            );

            DB::commit();
            return redirect('admin/users')->with('update', 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['fali' => 'something wrong'])->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return 'success';
    }
}
