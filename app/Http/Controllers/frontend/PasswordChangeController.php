<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function index(){
        return view('frontend.user.change_password');
    }
    public function changePassword(ChangePassword $request)
    {
        $user = Auth::guard('web')->user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->update();

            return redirect(route('password'))->with('update', 'Updated Successfully');
        } else {
            return redirect(route('password'))->with('error', 'Password is not correct');
        }
    }
}
