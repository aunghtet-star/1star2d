<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FixMoneyFromAdmin extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(AdminUser::class,'user_id');
    }

    public function getNameAttribute(){

        if($this->user_id){
            $value = AdminUser::find($this->user_id)->name;
            return $value;
        }else{
            return 'null';
        }
    }
}
