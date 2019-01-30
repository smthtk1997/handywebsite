<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function notpermission()
    {
        return view('guest.notpermission');
    }

    public function err404()
    {
        return view('guest.404');
    }

    public function err500()
    {
        return view('guest.500');
    }
}
