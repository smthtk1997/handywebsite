<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }



    /**
     * Switcher Route
     * if Admin redirect to /admin
     * but is user use UserController@index
     */

    public function index()
    {
        if (Auth::user()->role == 1){
            return redirect(route('admin.index'));
        }
        return (new UserController)->index();
    }

    public function redirect()
    {
        return redirect(route('home'));
    }


}
