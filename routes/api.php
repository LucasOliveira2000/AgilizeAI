<?php

use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(UserController::class)->prefix('user')->group(function(){
    Route::get('/profile', 'profile')->name('user.profile')->middleware('auth:sanctum');
    Route::post('/login', 'login')->name('user.login');
    Route::put('/edit', 'edit')->name('user.edit')->middleware('auth:sanctum');
    Route::post('/register', 'register')->name('user.register');
    Route::post('/logout', 'logout')->name('user.logout')->middleware('auth:sanctum');
    Route::delete('/delete', 'delete')->name('user.delete');
});

Route::middleware('auth:sanctum')->controller(ServicoController::class)->prefix('service')->group(function(){
    Route::get('/index', 'index')->name('service.index');
    Route::get('/show/{id}', 'show')->name('service.show');
    Route::post('/register', 'register')->name('service.register');
});
