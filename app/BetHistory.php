<?php

namespace App;

use App\User;
use App\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BetHistory extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getNameAttribute(){
        $user = Auth::guard('adminuser')->user();
        

        if($this->user_id){
            $value = User::find($this->user_id)->name;
            return $value;
        }else{
            return 'null';
        }
        

        
    }
}
