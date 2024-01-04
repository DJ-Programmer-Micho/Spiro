<?php

use App\Http\Middleware\Own;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\OwnController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckUserStatus;
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
Route::get('/pdf', function () { return view('pdf'); });

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
    Route::prefix('/emp')->middleware(['CheckUserStatus', 'Emp'])->group(function () {
        Route::get('/', [EmpController::class, 'dashboardEmp'])->name('emp.dashboard');
        Route::get('/mytask', [EmpController::class, 'myTask'])->name('emp.mytask');
    });

    Route::prefix('/own')->middleware(['CheckUserStatus', 'Own'])->group(function () {
        Route::get('/', [OwnController::class, 'dashboardOwn'])->name('own.dashboard');
        Route::get('/user', [OwnController::class, 'user'])->name('own.user');
        Route::get('/client', [OwnController::class, 'client'])->name('own.client');
        Route::get('/service', [OwnController::class, 'service'])->name('own.service');
        Route::get('/payment', [OwnController::class, 'payment'])->name('own.payment');
        Route::get('/expense', [OwnController::class, 'expense'])->name('own.expense');
        Route::get('/expense/bill', [OwnController::class, 'expenseBill'])->name('own.expense.bill');
        Route::get('/quotation', [OwnController::class, 'quotation'])->name('own.quotation');
        Route::get('/invoice', [OwnController::class, 'invoice'])->name('own.invoice');
        Route::get('/cash', [OwnController::class, 'cash'])->name('own.cash');
        Route::get('/createTask', [OwnController::class, 'createTask'])->name('own.createTask');
        Route::get('/addTask', [OwnController::class, 'addTask'])->name('own.addTask');
        Route::get('/plan/guestplanview', [OwnController::class, 'guestPlanView'])->name('guestPlanView');
        Route::get('/plan/plansetting', [OwnController::class, 'planSetting'])->name('planSetting');
        Route::get('/top8', [OwnController::class, 'topEight'])->name('topEight');
    });
});