<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Zorg\MeasurementController;

use App\Http\Controllers\Planner\ClientController as PlannerClientController;
use App\Http\Controllers\Planner\RouteController as PlannerRouteController;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ZorgPersoneelController;
use App\Http\Controllers\Zorg\ReportController; // <-- NIEUW

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
    // Planner dashboard
    Route::get('/planner/dashboard', [PlannerRouteController::class, 'index'])
        ->name('planner.dashboard');

    // Clients (planner)
    Route::get('/planner/clients', [PlannerClientController::class, 'index'])
        ->name('planner.clients.index');

    Route::get('/planner/clients/create', [PlannerClientController::class, 'create'])
        ->name('planner.clients.create');

    Route::post('/planner/clients', [PlannerClientController::class, 'store'])
        ->name('planner.clients.store');

    Route::get('/planner/clients/{client}/edit', [PlannerClientController::class, 'edit'])
        ->name('planner.clients.edit');

    Route::put('/planner/clients/{client}', [PlannerClientController::class, 'update'])
        ->name('planner.clients.update');

    Route::delete('/planner/clients/{id}', [PlannerClientController::class, 'destroy'])
        ->name('planner.clients.destroy');

    // Routes (planner)
    Route::get('/planner/routes/create', [PlannerRouteController::class, 'create'])
        ->name('planner.routes.create');

    Route::post('/planner/routes', [PlannerRouteController::class, 'store'])
        ->name('planner.routes.store');
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

    // =========================
    // Rapportages (zorgpersoneel)
    // =========================
    // Lijst + formulier (per client)
    Route::get('/zorg/clients/{client}/reports', [ReportController::class, 'index'])
        ->name('zorg.reports.index');

    // Opslaan nieuwe rapportage (per client)
    Route::post('/zorg/clients/{client}/reports', [ReportController::class, 'store'])
        ->name('zorg.reports.store');

    // Bewerken (alleen eigen rapportage)
    Route::get('/zorg/reports/{report}/edit', [ReportController::class, 'edit'])
        ->name('zorg.reports.edit');

    // Updaten (alleen eigen rapportage)
    Route::put('/zorg/reports/{report}', [ReportController::class, 'update'])
        ->name('zorg.reports.update');

    // Verwijderen (alleen eigen rapportage)
    Route::delete('/zorg/reports/{report}', [ReportController::class, 'destroy'])
        ->name('zorg.reports.destroy');

    Route::get('/zorg/clients/{client}/measurements', [MeasurementController::class, 'index'])
        ->name('zorg.measurements.index');

    Route::get('/zorg/clients/{client}/measurements/create', [MeasurementController::class, 'create'])
        ->name('zorg.measurements.create');

    Route::post('/zorg/clients/{client}/measurements', [MeasurementController::class, 'store'])
        ->name('zorg.measurements.store');

    // later: edit/update/delete (alleen eigen)
    Route::get('/zorg/measurements/{measurement}/edit', [MeasurementController::class, 'edit'])
        ->name('zorg.measurements.edit');

    Route::put('/zorg/measurements/{measurement}', [MeasurementController::class, 'update'])
        ->name('zorg.measurements.update');

    Route::delete('/zorg/measurements/{measurement}', [MeasurementController::class, 'destroy'])
        ->name('zorg.measurements.destroy');
});