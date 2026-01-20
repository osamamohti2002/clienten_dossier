<?php

namespace App\Http\Controllers;

class ZorgPersoneelController extends Controller
{
    public function dashboard()
    {
        return view('zorg.dashboard');
    }

    public function clients()
    {
        return view('zorg.clients.index');
    }
}