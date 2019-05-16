<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','shop_id','message','rating','token'];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function get_user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}
