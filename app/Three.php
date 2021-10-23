<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Three extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
