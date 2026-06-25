<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ReviewController;



Route::get('/', function (){
    return redirect()->route('phones.index');
});
Route::get('/phones', [HomeController::class, 'show'])->name('phones.index');
Route::get('/phones/{phone}', [PhoneController::class, 'show'])->name('phones.show');
Route::get('/brands/{brand}/phones', [HomeController::class, 'show'])->name('brands.phones');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('/privacy', 'privacy');

Route::middleware('auth')->group(function () {
    Route::post('/phones/{phone}/reviews', [ReviewController::class, 'store'])->name('review.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{item}/increase', [CartController::class, 'increase'])->name('cart.increase');
    Route::patch('/cart/{item}/decrease', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/add/{phone}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
