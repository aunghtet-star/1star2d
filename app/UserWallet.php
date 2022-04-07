<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserWallet extends Model
{
   protected $guarded = [];

   public function getNameAttribute(){
        if($this->user_id){
            $value = User::find($this->user_id)->name;
            return $value;
        }else{
            return 'null';
        }
    }

}
