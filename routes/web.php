<?php

use Illuminate\Support\Facades\Route;
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