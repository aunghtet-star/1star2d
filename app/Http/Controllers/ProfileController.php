<?php

namespace App\Http\Controllers;

use App\Wallet;
use App\AdminUser;
use App\Http\Requests\UpdatePassword;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::guard('adminuser')->user()->can('view_profile')) {
            $admin_wallet = Wallet::where('admin_user_id', Auth::guard('adminuser')->user()->id)->where('status', 'admin')->first();
            return view('backend.profile.index', compact('admin_wallet'));
        } else {
            return abort(404);
        }
    }

    public function updatepassword()
    {
        if (Auth::guard('adminuser')->user()->can('view_updatepassword')) {
            return view('backend.profile.updatepassword');
        } else {
            return abort(404);
        }
    }

    public function store(UpdatePassword $request)
    {
        $admin= Auth::guard('adminuser')->user();
        
        if (Hash::check($request->oldpassword, $admin->password)) {
            $admin->password  = Hash::make($request->newpassword);
            $admin->update();
            
            return back()->with('update', 'Password Updated successfully');
        } else {
            return back()->withErrors(['oldpassword'=> 'Wrong Password !!!'])->withInput();
        }
    }

    public function transactions()
    {
        $transactions = Transaction::where('user_id', Auth::guard('adminuser')->user()->id)->orderBy('created_at', 'DESC')->paginate(5);
        return view('backend.profile.transaction', compact('transactions'));
    }
}
