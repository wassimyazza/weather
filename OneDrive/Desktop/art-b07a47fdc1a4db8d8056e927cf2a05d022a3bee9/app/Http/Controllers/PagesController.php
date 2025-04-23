<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function customOrder()
    {
        return view('custom-order');
    }

    public function cart()
    {
        return view('cart');
    }
}