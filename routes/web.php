<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;


use \App\Models\User;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;
use Symfony\Component\Routing\Route as RoutingRoute;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('index');
Route::post('/', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Route::get('/admin/dashboard', function(){
//     return view('admin.dashboard');
// })->name('admin.dashboard');

Route::middleware(['role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])
    ->name('admin.users.destroy');
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