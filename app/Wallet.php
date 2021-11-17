<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function adminuser()
    {
        return $this->belongsTo('App\AdminUser', 'admin_user_id', 'id');
    }
}
