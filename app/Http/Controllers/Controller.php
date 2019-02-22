<?php

namespace App\Http\Controllers;

use App\Shop;
use App\ShopType;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('welcome');
    }


    public function stampspv() // crud
    {
        return view('layouts.stampspv');
    }

    public function test()
    {
//        $shop = User::find(Auth::user()->id)->shops()->get();
//        $shop = Auth::user()->shops()->get();

        $shop = Shop::find(1)->shop_types()->get();
        foreach ($shop as $sho){
            $type = $sho->type->name;
            $sho->typeName = $type;
        }

        return $shop;
    }
}
