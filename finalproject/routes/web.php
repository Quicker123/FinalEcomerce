<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\User\OrderController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('owner')->name('admin.')->group(function () {
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('dashboard', DashboardController::class);
});
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('order', OrderController::class);
    Route::get('/home', [OrderController::class, 'home']);
    Route::get('/checkout', [OrderController::class, 'checkout']);
    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::get('/removeItem/{id}', [TransactionController::class, 'destroy']);
    Route::post('/paymentVerify', [TransactionController::class, 'khaltiPay']);
});
Route::get('/productdetail/{id}', [UserProductController::class, 'index'])->name('userproduct.index');

Route::post('/postComment', [UserProductController::class, 'store'])->name('userproduct.store');

Route::post('/ajaxRequest', [OrderController::class, 'ajaxRequest'])->name('user.ajax');

Route::get('/orderChanger', [OrderController::class, 'orderChanger'])->name('user.orderChanger');
