<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','img_logo','token'];

    public function getRouteKeyName()
    {
        return 'token';
    }

}
