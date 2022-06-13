<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manager\DashboardController as managerDashboard;

use App\Http\Controllers\Kasir\DashboardController as kasirDashboard;

use App\Http\Controllers\Supplier\DashboardController as supplierDashboard;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => ['role:manager']], function () {
        //Dashboard
        Route::get('manager/dashboard', [managerDashboard::class, 'index'])->name('manager.dashboard');
    });

    Route::group(['middleware' => ['role:kasir']], function () {
        // Dashboard
        Route::get('kasir/dashboard', [kasirDashboard::class, 'index'])->name('kasir.dashboard');
    });

    Route::group(['middleware' => ['role:supplier']], function () {
        // Dashboard
        Route::get('supplier/dashboard', [supplierDashboard::class, 'index'])->name('supplier.dashboard');
    });
});