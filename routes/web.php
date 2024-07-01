<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('productos.index');
});
Route::get('/payments/{id}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');

Route::post('/payment/Card', [PaymentController::class, 'processCard'])->name('payment.card');
Route::post('/payment/Qr', [PaymentController::class, 'processQr'])->name('payment.qr');
Route::post('/payment/paypal', [PaymentController::class, 'processPaypal'])->name('payment.paypal');
Route::get('/payment/paypal/status', [PaymentController::class, 'paypal_status'])->name('payment.paypal.status');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');


Route::resource('/productos', ProductController::class);


Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');

