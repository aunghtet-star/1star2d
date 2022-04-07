<?php

namespace App;

use App\Master;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Master extends Authenticatable
{
    protected $guarded = [];

    use HasRoles;
}
