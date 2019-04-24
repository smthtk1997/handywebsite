<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{


    public function shop_types()
    {
        return $this->hasMany('App\ShopType');
    }


}
