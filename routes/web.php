<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manager\DashboardController as managerDashboard;
use App\Http\Controllers\Manager\SupplyController as managerSupply;
use App\Http\Controllers\Manager\KategoriController as managerKategoriMenu;
use App\Http\Controllers\Manager\MenuController as managerMenu;
use App\Http\Controllers\Manager\PesanController as managerPesan;

use App\Http\Controllers\Kasir\DashboardController as kasirDashboard;
use App\Http\Controllers\Kasir\TransactionController as kasirTransaksi;

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
        Route::get('ajax/manager/kategori/getKategori', [managerKategoriMenu::class, 'getKategori'])->name('manager.kategori.getKategori');
        
        // Menu
        Route::resource('menu', managerMenu::class);
        Route::get('manager/menu/getFieldSupply', [managerMenu::class, 'getSupplyField'])->name('manager.menu.getSupplyField');
        Route::get('manager/menu/addStock/{menu}', [managerMenu::class, 'addStock'])->name('manager.menu.addStock');
        Route::get('manager/menu/addDetailSupplyMenu/{menu}', [managerMenu::class, 'addDetailSupplyMenu'])->name('manager.menu.addDetailSupplyMenu');
        Route::put('manager/menu/emptyStock/{menu}', [managerMenu::class, 'emptyStock'])->name('manager.menu.emptyStock');
        Route::post('manager/menu/storeStock/{menu}', [managerMenu::class, 'storeStock'])->name('manager.menu.storeStock');
        Route::post('manager/menu/storeDetailSupplyMenu/{menu}', [managerMenu::class, 'storeDetailSupplyMenu'])->name('manager.menu.storeDetailSupplyMenu');
        
        Route::delete('manager/menu/{menu}/deleteItem/{id}', [managerMenu::class, 'destroyDetailSupplyMenu'])->name('manager.menu.destroyDetailSupplyMenu');

        Route::get('ajax/manager/getMenu', [managerMenu::class, 'getMenu'])->name('manager.getMenu');
        Route::get('ajax/manager/getKategori', [managerMenu::class, 'getKategori'])->name('manager.menu.getKategori');
        Route::get('ajax/manager/getDetailSupplyMenu/{id}', [managerMenu::class, 'getDetailSupplyMenu'])->name('manager.menu.getDetailSupplyMenu');

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
        // Transaksi
        Route::resource('kasir_transaksi', kasirTransaksi::class);
        Route::get('ajax/kasir/getMenu', [kasirTransaksi::class, 'getMenu'])->name('kasir.transaksi.getMenu');
        Route::get('ajax/kasir/getDetailTransaksi/{transaksi}', [kasirTransaksi::class, 'getDetailTransaksi'])->name('kasir.transaksi.getDetailTransaksi');

        Route::post('ajax/kasir/transaksi/{transaksi}/menu/{menu}/updateItem', [kasirTransaksi::class, 'updateItem'])->name('kasir.transaksi.updateItem');
        Route::post('ajax/kasir/transaksi/{transaksi}/menu/{menu}/deleteItem', [kasirTransaksi::class, 'deleteItem'])->name('kasir.transaksi.deleteItem');
        Route::post('ajax/kasir/transaksi/{transaksi}/menu/{menu}/addDetailTransaksi', [kasirTransaksi::class, 'addDetailTransaksi'])->name('kasir.transaksi.addDetailTransaksi');
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