<?php

use App\Http\Controllers\CategoryController;
use \App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

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
//Dashboard
Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::delete('/{id}', [DashboardController::class,'transactionDelete'])->name('Dtransactions.destroy');
Route::post('Dtransactions/store', [DashboardController::class,'transactionStore'])->name('Dtransactions.store');
//Transactions
Route::get('transactions/list',[DashboardController::class,'listTransactions'])->name('transactions.list');
