<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded = [];

    protected $append = ['name'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function adminuser()
    {
        return $this->belongsTo('App\AdminUser', 'admin_user_id', 'id');
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
