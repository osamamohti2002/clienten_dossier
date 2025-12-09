<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('index');
    }

    public function login(Request $request){

        // hiermee valideer ik de gegevens die we binnen krijgen
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        //check op de gegevens

        if(!Auth::attempt($credentials)){
            return back()->withErrors([
                'email' => 'Emailadres of wachtwoord zijn onjuist. ',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $role = Auth::user()->role->name;

        switch($role){
            case 'admin';
                return redirect()->route('admin.dashboard');

            case 'planner';
                return redirect()->route('planner.dashboard');

            case 'zorgpersoneel';
                return redirect()->route('zorg.dashboard');
        }

    }


}
