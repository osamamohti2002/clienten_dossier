<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });
    
    Route::get('/create', function () {
        return view('admin.create');
    });

    Route::get('/edit', function () {
        return view('admin.edit');
    });
});