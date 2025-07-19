<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicMenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);

    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');


    Route::resource('menus', MenuController::class);

});

Route::get('/cardapio', [PublicMenuController::class, 'index'])->name('public.index');
Route::get('/cardapio/{slug}', [PublicMenuController::class, 'show'])->name('public.menu');

Route::get('/cardapio/{slug}/checkout', [PublicMenuController::class, 'checkout'])->name('public.checkout');
Route::post('/cardapio/{slug}/checkout', [PublicMenuController::class, 'submitOrder'])->name('public.submit');

Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CartController::class, 'form'])->name('checkout.form');
Route::post('/checkout', [CartController::class, 'submit'])->name('checkout.submit');

Route::get('/order/details', [PublicMenuController::class, 'details'])->name('public.order.details');


require __DIR__.'/auth.php';
