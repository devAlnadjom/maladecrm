<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DriverController;

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


Route::post('/shop/purchase', [UserController::class, 'purchase'])->name('order.purchase');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('/cart/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
Route::get('/cart', [CartController::class, 'index'])->name('cart.show');

Route::get('/shop/how_it_works', [ShopController::class, 'howItWorks'])->name('shop.how');
Route::get('/order/tracking/{id}/{key}',[ShopController::class, 'tracking'] )->name('order.tracking');
Route::get('/order/sumary',[ShopController::class, 'sumary'] )->name('order.sumary');
Route::get('/order/checkout',[ShopController::class, 'checkout'] )->name('order.checkout');
Route::post('/order/step2',[ShopController::class, 'storeRecipient'] )->name('store.recipient');
Route::get('/order/step2',[ShopController::class, 'step2'] )->name('order.recipient');
Route::get('/product/{slug}/{id}',[ShopController::class, 'viewone'] )->name('product.view');

Route::get('/', [ShopController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified','IsAdmo'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth','IsAdmo'])->group(function () {
    Route::get('about', function () {
            return Inertia::render('About');
        })->name('about');


    Route::resource('categories', CategoryController::class);

    Route::post('products/add_feature', [ProductController::class,'add_feature'])->name('products.add_feature');
    Route::post('products/remove_feature', [ProductController::class,'remove_feature'])->name('products.remove_feature');
    Route::post('products/add_category', [ProductController::class,'add_category'])->name('products.add_category');
    Route::post('products/add_media', [ProductController::class,'add_media'])->name('products.add_media');
    Route::post('products/remove_media', [ProductController::class,'remove_media'])->name('products.remove_media');
    Route::post('products/add_category', [ProductController::class,'add_category'])->name('products.add_category');
    Route::post('products/remove_category', [ProductController::class,'remove_category'])->name('products.remove_category');
    
    Route::resource('products', ProductController::class);
    Route::resource('delivery', DeliveryController::class);
    Route::resource('order', OrderController::class);
    Route::resource('driver', DriverController::class);
    Route::get('users', [UserController::class, 'index'])->name('users.index');


    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('admin/link', function () {
        $exitCode = Artisan::call('storage:link');
        echo $exitCode;
    });
});

Route::get('admin/mimi', function () {
    $exitCode = Artisan::call('migrate');
    echo $exitCode;
});
