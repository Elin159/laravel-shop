<?php

namespace App;

use App\Mode\UserAuth;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

    public function userAuths() {
        return $this->hasMany(UserAuth::class,'user_id','id');
    }

    public function toEditPassword($password) {
        $userAuths = $this->userAuths;
        foreach($userAuths as $userAuth) {
            $userAuth->credential = bcrypt($password);
            $userAuth->save();
        }
        return true;
    }
}
