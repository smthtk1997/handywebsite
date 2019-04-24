<?php

namespace App\Http\Controllers;

use App\UserCars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FuelLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    public function fuelLogIndex(){
        $cars = UserCars::where('user_id',Auth::user()->id)->get();
        return view('users.FuelLog.fuellogIndex',['cars'=>$cars]);
    }


}
