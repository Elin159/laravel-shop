<?php

namespace App\Mode;

use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
class UserAuth extends Authenticatable
{
    protected $table = 'user_auths';

    protected $fillable = ['user_id','identity','identifier','credential'];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
