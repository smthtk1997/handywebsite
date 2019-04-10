<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password','token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

//    public function shops()
//    {
//        return $this->hasMany('App\Shop');
//    }

}
