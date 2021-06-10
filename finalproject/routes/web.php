<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Models\Category;
use App\Models\Product;
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

Route::prefix('owner')->name('admin.')->group(function () {
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('dashboard', DashboardController::class);
});

Route::get('/home', function(){
    $products = Product::all();
    $categories = Category::all();
    $subcategories = SubCategory::all();
    return view('home', compact(['products', 'categories', 'subcategories']));
});


Route::get('/productdetail', function(){
    $products = Product::all();
    $categories = Category::all();
    $subcategories = SubCategory::all();
    return view('productDetail',  compact(['products', 'categories', 'subcategories']));
});