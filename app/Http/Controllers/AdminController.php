<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.index');
    }
}
