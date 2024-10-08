<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\authMiddleware;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Export;
use App\Http\Middleware\loginMiddleware;
use App\Http\Middleware\AdminMiddleware;


Route::get('/',[HomeController::class, 'showHomePage'])->middleware([loginMiddleware::class]);
Route::get('/insertScrollNews/{page}',[HomeController::class, 'insertNews']);

Route::get('/filter',[HomeController::class, 'showFilterNews'])->middleware([loginMiddleware::class]);
Route::get('/insertScrollNewsWhitFilters',[HomeController::class, 'insertScrollNewsWhitFilters']);

Route::get('/searchResult',[HomeController::class, 'searchResultNews'])->middleware([loginMiddleware::class]);
Route::get('/insertSearchScrollNews',[HomeController::class, 'insertSearchScrollNews']);

Route::get('/login', [loginController::class, 'loginView'])->name('login')->middleware(authMiddleware::class); //روت نمایش ویو صفحه ورود
Route::post('/login', [loginController::class, 'login']); //روت پست اطلاعات فرم ورود
Route::get('/logout', [loginController::class, 'logout']);
Route::get('/singleBlockNews/{news_id}', [HomeController::class, 'singleBlockNews']);
Route::get('/multiBlockNews/{page}', [HomeController::class, 'multiBlockNews']);
Route::get('/addNewNewsBlock', [HomeController::class, 'addNewNewsBlock']);
Route::get('/newsHash/{page}', [HomeController::class, 'getNewsHash']);

Route::get('/transfer', [HomeController::class, 'transferData']);







Route::prefix('/admin')->middleware([AdminMiddleware::class])->group(function () {
    Route::get('/', [admin::class, 'showDashboard']);

    Route::get('/addNews', [admin::class, 'showAddNewsForm']);
    Route::post('/addNews', [admin::class, 'addNews']);

    Route::get('/onlineEdit', [admin::class, 'onlineEdit']);
    Route::post('/editNews', [admin::class, 'editNews']);
    Route::get('/addDetailsForm/{details_id}', [admin::class, 'addDetailsForm']);
    Route::get('/deleteDetailsForm/{details_id}', [admin::class, 'deleteDetailsForm']);
    Route::get('/deleteNewsForm/{news_id}', [admin::class, 'deleteNewsForm']);

    Route::get('/insertScrollNews', [admin::class, 'insertScrollNews']);

    Route::get('/exportAll', [Export::class, 'exportAll']);
    Route::get('/exportImportant', [Export::class, 'exportImportant']);

    Route::get('/usersPanel', [admin::class, 'usersPanel']);
    Route::get('/deleteUser/{user_id}', [admin::class, 'deleteUser']);
    Route::get('/addUserForm', [admin::class, 'addUserForm']);
    Route::post('/addUser', [admin::class, 'addUser']);
    Route::get('/editUserForm/{user_id}', [admin::class, 'editUserForm']);
    Route::post('/editUser', [admin::class, 'editUser']);
});
