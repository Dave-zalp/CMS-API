<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::group(['middleware' => 'auth:sanctum'], function(){

Route::get('/user', function (Request $request) {
        return $request->user();
    });

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/index', [UserController::class, 'index'])->name('index');

});

Route::group(['middleware' => 'guest'], function (){

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

});



