<?php

namespace App;

use App\User;
use App\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletHistory extends Model
{
    protected $append = ['name'];

    public function adminuser(){
        return $this->belongsTo(AdminUser::class,'user_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getNameAttribute(){
        $user = Auth::guard('adminuser')->user();
        
        if($user->hasRole('Admin') || $user->hasRole('Master') ){
            if($this->user_id){
                $value = AdminUser::find($this->user_id) ? AdminUser::find($this->user_id)->name : 'null';
                return $value;
            }else{
                return 'null';
            }
        }

        if($user->hasRole('Agent')){
            if($this->user_id){
                $value = User::find($this->user_id)->name;
                return $value;
            }else{
                return 'null';
            }
        }

        
    }
}
