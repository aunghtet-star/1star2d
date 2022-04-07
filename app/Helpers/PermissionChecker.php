<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

Class PermissionChecker {
    public static function CheckPermission($permission){
        if(Auth::guard('adminuser')->user()->can($permission)){
            return true;
        }else{
            abort(403);
        }
    }
}