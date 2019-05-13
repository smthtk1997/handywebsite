<?php

namespace App\Http\Controllers;

use App\Insurance;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    public function index()
    {
        $insurances = Insurance::all();
        return view('Home.handy',['insurances'=>$insurances]);
    }
}
