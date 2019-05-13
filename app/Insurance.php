<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurance extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','type_id','token'];

    public function getRouteKeyName()
    {
        return 'token';
    }
}
