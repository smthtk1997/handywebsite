<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCars extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','name','license','brand_id','model','mileage','img_path','token'];
    protected $appends = ['FullName'];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function getFullNameAttribute()
    {
        $name = ucfirst($this->brand).' '.ucfirst($this->model);
        return "{$name}";
    }


}
