<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\authMiddleware;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin;
use App\Http\Middleware\loginMiddleware;


Route::get('/',[HomeController::class, 'showHomePage']);
Route::get('/insertScrollNews/{page}',[HomeController::class, 'insertNews']);
Route::get('/login', [loginController::class, 'loginView'])->name('login')->middleware(authMiddleware::class); //روت نمایش ویو صفحه ورود
Route::post('/login', [loginController::class, 'login']); //روت پست اطلاعات فرم ورود
Route::get('/logout', [loginController::class, 'logout']);





Route::prefix('/admin')->middleware([loginMiddleware::class])->group(function () {
    Route::get('/', [admin::class, 'showDashboard']);

    Route::get('/addNews', [admin::class, 'showAddNewsForm']);
    Route::post('/addNews', [admin::class, 'addNews']);

    Route::get('/onlineEdit', [admin::class, 'onlineEdit']);
    Route::post('/editNews', [admin::class, 'editNews']);
    Route::get('/addDetailsForm/{details_id}', [admin::class, 'addDetailsForm']);
    Route::get('/deleteDetailsForm/{details_id}', [admin::class, 'deleteDetailsForm']);

    Route::get('/insertScrollNews/{page}', [admin::class, 'insertScrollNews']);
});
