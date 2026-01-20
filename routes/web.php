<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Planner\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Planner\RouteController;
use App\Http\Controllers\ZorgPersoneelController;
use App\Models\Zorgpersoneel;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('index');
Route::post('/', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/create', [AdminController::class, 'store'])->name('admin.store');

    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
});

 
 
    Route::middleware(['role:planner'])->group(function () {

    //  Planner dashboard
    Route::get('/planner/dashboard', [RouteController::class, 'index'])
        ->name('planner.dashboard');

    // Clients
    Route::get('/planner/clients', [ClientController::class, 'index'])
        ->name('planner.clients.index');

    Route::get('/planner/clients/create', [ClientController::class, 'create'])
        ->name('planner.clients.create');

    Route::post('/planner/clients', [ClientController::class, 'store'])
        ->name('planner.clients.store');

    Route::delete('/planner/clients/{id}', [ClientController::class, 'destroy'])
        ->name('planner.clients.destroy');

    //  Routes 
    Route::get('/planner/routes/create', [RouteController::class, 'create'])
        ->name('planner.routes.create');

    Route::post('/planner/routes', [RouteController::class, 'store'])
        ->name('planner.routes.store');

            // Edit client
    Route::get('/planner/clients/{client}/edit', [ClientController::class, 'edit'])
        ->name('planner.clients.edit');

    // Update client
    Route::put('/planner/clients/{client}', [ClientController::class, 'update'])
        ->name('planner.clients.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::middleware(['role:zorgpersoneel'])->group(function () {

    Route::get('/zorg/dashboard', [ZorgPersoneelController::class, 'dashboard'])
        ->name('zorg.dashboard');

    Route::get('/zorg/clients', [ZorgPersoneelController::class, 'clients'])
        ->name('zorg.clients.index');

    Route::get('/zorg/clients/{client}/reports', [ZorgPersoneelController::class, 'reports'])
        ->name('zorg.clients.reports');

    Route::post('/zorg/clients/{client}/reports', [ZorgPersoneelController::class, 'storeReport'])
    ->name('zorg.clients.reports.store');


});