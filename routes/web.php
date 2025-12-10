<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('index');
Route::post('/', [LoginController::class, 'login'])->name('login.post');

// Route::get('/admin/dashboard', function(){
//     return view('admin.dashboard');
// })->name('admin.dashboard');

Route::middleware(['role:admin'])->group(function(){
    Route::get('/admin/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
 
 
Route::middleware(['role:planner'])->group(function(){
    Route::get('/planner/dashboard', function(){
        return view('planner/dashboard');
    })->name('planner.dashboard');
});


Route::middleware(['role:zorgpersoneel'])->group(function(){
    Route::get('/zorg/dashboard', function(){
        return view('zorg/dashboard');
    })->name('zorg.dashboard');
});

