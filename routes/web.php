<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Planner\ClientController;
use Illuminate\Support\Facades\Route;
use \App\Models\User;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;
use Symfony\Component\Routing\Attribute\Route as AttributeRoute;
use Symfony\Component\Routing\Route as RoutingRoute;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('index');
Route::post('/', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Route::get('/admin/dashboard', function(){
//     return view('admin.dashboard');
// })->name('admin.dashboard');

Route::middleware(['role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/create',[AdminController::class,'create'])->name('admin.create');
    Route::post('/admin/create',[AdminController::class,'store'])->name('admin.store');

    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])
    ->name('admin.users.destroy');

    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])
    ->name('admin.users.edit');

    Route::put('/admin/users/{id}', [AdminController::class, 'update'])
    ->name('admin.users.update');
    });

 
 
    Route::middleware(['role:planner'])->group(function(){
        Route::get('/planner/dashboard', function(){
            return view('planner/dashboard');
        })->name('planner.dashboard');
    
        // Clients
        Route::get('/planner/clients', [ClientController::class, 'index'])
            ->name('planner.clients.index');

        Route::get('/planner/clients/create', [ClientController::class, 'create'])
            ->name('planner.clients.create');

        Route::post('/planner/clients', [ClientController::class, 'store'])
            ->name('planner.clients.store');

        Route::delete('/planner/clients/{id}', [ClientController::class, 'destroy'])
            ->name('planner.clients.destroy');
    });

Route::middleware(['role:zorgpersoneel'])->group(function(){
    Route::get('/zorg/dashboard', function(){
        return view('zorg/dashboard');
    })->name('zorg.dashboard');
});