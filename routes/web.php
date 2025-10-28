<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchSessionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\LocaleController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('products', ProductController::class)->except(['show']);
Route::resource('customers', CustomerController::class)->except(['show']);
Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);

// Branch management
Route::resource('branches', BranchController::class);
Route::post('branches/switch', [BranchSessionController::class, 'update'])->name('branches.switch');

// Procurement
Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::post('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
Route::get('purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');

// Warehouse transfers
Route::get('transfers', [StockTransferController::class, 'index'])->name('transfers.index');
Route::get('transfers/create', [StockTransferController::class, 'create'])->name('transfers.create');
Route::post('transfers', [StockTransferController::class, 'store'])->name('transfers.store');

// Accounting
Route::get('accounting/pl', [AccountingController::class, 'profitAndLoss'])->name('accounting.pl');
Route::get('accounting/entries', [JournalEntryController::class, 'index'])->name('accounting.entries.index');
Route::get('accounting/entries/create', [JournalEntryController::class, 'create'])->name('accounting.entries.create');
Route::post('accounting/entries', [JournalEntryController::class, 'store'])->name('accounting.entries.store');

// Locale switch
Route::post('locale/switch', [LocaleController::class, 'update'])->name('locale.switch');
