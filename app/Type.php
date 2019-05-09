<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function shop_type()
    {
        return $this->belongsTo('App\ShopType','type_id');
    }
}
