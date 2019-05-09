<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopType extends Model
{

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function type()
    {
        return $this->belongsTo('App\Type','type_id');
    }


}
