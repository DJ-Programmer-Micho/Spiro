<?php

use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.layout');
});

Route::get('/client', [DashboardController::class, 'client'])->name('client');
Route::get('/service', [DashboardController::class, 'service'])->name('service');
Route::get('/branch', [DashboardController::class, 'branch'])->name('branch');

//Quotation
Route::get('/quotation', [DashboardController::class, 'quotation'])->name('quotation');

Route::middleware([Localization::class])->group(function () {
/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
*/   
    Route::get('/login', [AuthController::class,'index'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('logging');
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
/*
|--------------------------------------------------------------------------
| MET ROUTE SUPER ADMIN
|--------------------------------------------------------------------------
*/  
    Route::prefix('/own')->group(function () {
    Route::get('/', [OwnController::class, 'dashboardOwn'])->name('dashboardOwn');
    Route::get('/addclient', [OwnController::class, 'addclient'])->name('addclient');
    Route::get('/userinformation', [OwnController::class, 'userInformation'])->name('userInformation');
    Route::get('/usersdata', [OwnController::class, 'userData'])->name('userData');
    Route::get('/plan/userplanview', [OwnController::class, 'userPlanView'])->name('userPlanView');
    Route::get('/plan/guestplanview', [OwnController::class, 'guestPlanView'])->name('guestPlanView');
    Route::get('/plan/plansetting', [OwnController::class, 'planSetting'])->name('planSetting');
    Route::get('/top8', [OwnController::class, 'topEight'])->name('topEight');
    });
});