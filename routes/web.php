<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\authMiddleware;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin;


Route::get('/',[HomeController::class, 'showHomePage']);
Route::get('/login', [loginController::class, 'loginView'])->name('login')->middleware(authMiddleware::class);; //روت نمایش ویو صفحه ورود
Route::post('/login', [loginController::class, 'login']); //روت پست اطلاعات فرم ورود
Route::get('/logout', [loginController::class, 'logout']);

Route::prefix('/admin')->group(function () {
    Route::get('/', [admin::class, 'showDashboard']);

    Route::get('/addNews', [admin::class, 'showAddNewsForm']);
    Route::post('/addNews', [admin::class, 'addNews']);
});
