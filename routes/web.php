<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manager\DashboardController as managerDashboard;
use App\Http\Controllers\Manager\SupplyController as managerSupply;
use App\Http\Controllers\Manager\KategoriController as managerKategoriMenu;
use App\Http\Controllers\Manager\MenuController as managerMenu;
use App\Http\Controllers\Manager\PesanController as managerPesan;

use App\Http\Controllers\Kasir\DashboardController as kasirDashboard;

use App\Http\Controllers\Supplier\DashboardController as supplierDashboard;
use App\Http\Controllers\Supplier\SupplyController as supplierSupply;
use App\Http\Controllers\Supplier\PesanController as supplierPesanan;


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
        //Supply
        Route::resource('supply', managerSupply::class);
        Route::get('ajax/getSupply', [managerSupply::class, 'getSupply'])->name('manager.getSupply');
        // Kategori Menu
        Route::resource('kategori', managerKategoriMenu::class);
        Route::get('ajax/manager/getKategori', [managerKategoriMenu::class, 'getKategori'])->name('manager.getKategori');
        // Menu
        Route::resource('menu', managerMenu::class);
        Route::get('ajax/manager/getMenu', [managerMenu::class, 'getMenu'])->name('manager.getMenu');
        // Pesan Bahan Baku
        Route::resource('pesanan', managerPesan::class);
        
        Route::get('ajax/manager/getPrice/{id}', [managerPesan::class, 'getPrice'])->name('manager.getPrice');
        Route::get('ajax/manager/getAllSupply', [managerPesan::class, 'getAllSupply'])->name('manager.getAllSupply');
        Route::get('ajax/manager/getSupplyOrder/{id}', [managerPesan::class, 'getSupplyOrder'])->name('manager.getSupplyOrder');
        Route::get('ajax/manager/getAllSupplyOrder', [managerPesan::class, 'getAllSupplyOrder'])->name('manager.getAllSupplyOrder');
        Route::get('ajax/manager/getSupplyDetailOrder/{supplyOrder}', [managerPesan::class, 'getSupplyDetailOrder'])->name('manager.getSupplyDetailOrder');
        
        Route::post('ajax/manager/storeDetailOrderSupply/{id}', [managerPesan::class, 'storeDetailOrderSupply'])->name('manager.storeDetailOrderSupply');
        Route::post('ajax/OrderSupply/{supplyOrder}/supply/{supply}/plusItem', [managerPesan::class, 'plusDetailOrderSupplyItem'])->name('manager.plusDetailOrderSupplyItem');
        Route::post('ajax/OrderSupply/{supplyOrder}/supply/{supply}/minusItem', [managerPesan::class, 'minusDetailOrderSupplyItem'])->name('manager.minusDetailOrderSupplyItem');
        Route::post('ajax/OrderSupply/{supplyOrder}/supply/{supply}/deleteItem', [managerPesan::class, 'deleteDetailOrderSupplyItem'])->name('manager.deleteDetailOrderSupplyItem');

        Route::put('ajax/manager/updateStatus/{id}', [managerPesan::class, 'updateStatus'])->name('manager.updateStatus');
    });

    Route::group(['middleware' => ['role:kasir']], function () {
        // Dashboard
        Route::get('kasir/dashboard', [kasirDashboard::class, 'index'])->name('kasir.dashboard');
        Route::get('ajax/kasir/getMenu', [kasirDashboard::class, 'getMenu'])->name('kasir.getMenu');
    });

    Route::group(['middleware' => ['role:supplier']], function () {
        // Dashboard
        Route::get('supplier/dashboard', [supplierDashboard::class, 'index'])->name('supplier.dashboard');
        // Supply
        Route::resource('supplier', supplierSupply::class);
        Route::get('ajax/supplier/getSupply', [supplierSupply::class, 'getSupply'])->name('supplier.getSupply');
        Route::get('ajax/supplier/getStatusSupply', [supplierSupply::class, 'getStatusSupply'])->name('supplier.getStatusSupply');
        // Pesanan List
        Route::resource('supplier_pesanan', supplierPesanan::class);
        Route::get('ajax/supplier/getSupplyOrder', [supplierPesanan::class, 'getSupplyOrder'])->name('supplier.getSupplyOrder');
        Route::put('ajax/supplier/updateStatus/{id}', [supplierPesanan::class, 'updateStatus'])->name('supplier.updateStatus');
        Route::delete('ajax/supplier/cancelOrder/{id}', [supplierPesanan::class, 'cancelOrder'])->name('supplier.cancelOrder');
    });
});