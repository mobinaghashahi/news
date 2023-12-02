<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\authMiddleware;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\HomeController;


Route::get('/',[HomeController::class, 'showHomePage']);
Route::get('/login', [loginController::class, 'loginView'])->name('login')->middleware(authMiddleware::class);; //روت نمایش ویو صفحه ورود
Route::post('/login', [loginController::class, 'login']); //روت پست اطلاعات فرم ورود
Route::get('/logout', [loginController::class, 'logout']);
