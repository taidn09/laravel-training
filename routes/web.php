<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\GroupsController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.');
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/{id}', [UsersController::class, 'detail']);
        Route::post('/', [UsersController::class, 'filter']);
        Route::post('/store', [UsersController::class, 'store']);
        Route::put('/{id}/update', [UsersController::class, 'update']);
        Route::put('/{id}/block', [UsersController::class, 'block']);
        Route::delete('/{id}', [UsersController::class, 'delete']);
    });

    Route::prefix('groups')->name('groups.')->group(function () {
        // Route::get('/', [GroupsController::class, 'index'])->name('index');
        Route::post('/', [GroupsController::class, 'filter'])->name('fiter');
        Route::post('/store', [GroupsController::class, 'store']);
    });
});

Route::post('upload', [UploadController::class, 'index']);