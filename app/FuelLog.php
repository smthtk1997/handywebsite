<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['car_id',
        'img_slip',
        'filling_date',
        'filling_time',
        'mileage',
        'gas_station',
        'fuel_type',
        'price_liter',
        'total_price',
        'total_liter',
        'filling_lat',
        'filling_lng',
        'token'
        ];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function get_car()
    {
        return $this->hasOne('App\UserCars','id','car_id');
    }
}
