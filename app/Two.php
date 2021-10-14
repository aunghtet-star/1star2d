<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Two extends Model
{
    protected $guarded = [];
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
