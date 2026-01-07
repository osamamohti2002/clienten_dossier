<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Planner\ClientController;
use App\Http\Controllers\Planner\RouteController;
use Illuminate\Support\Facades\Route;

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

    // ✅ Planner dashboard should be handled by controller (so it can pass $routes)
    Route::get('/planner/dashboard', [RouteController::class, 'index'])
        ->name('planner.dashboard');

    // Clients
    Route::get('/planner/clients', [ClientController::class, 'index'])->name('planner.clients.index');
    Route::get('/planner/clients/create', [ClientController::class, 'create'])->name('planner.clients.create');
    Route::post('/planner/clients', [ClientController::class, 'store'])->name('planner.clients.store');
    Route::delete('/planner/clients/{id}', [ClientController::class, 'destroy'])->name('planner.clients.destroy');

    // ✅ Routes (create + store)
    Route::get('/planner/routes/create', [RouteController::class, 'create'])
        ->name('planner.routes.create');

    Route::post('/planner/routes', [RouteController::class, 'store'])
        ->name('planner.routes.store');
});

Route::middleware(['role:zorgpersoneel'])->group(function () {
    Route::get('/zorg/dashboard', function () {
        return view('zorg/dashboard');
    })->name('zorg.dashboard');
});
