<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialFacebookAccount extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'provider_user_id', 'provider','token'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
