<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Checkout\CheckoutController;

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

Route::prefix('user')->group(function () {
    Route::post('/register', [UserController::class, 'store'])->name('user.register');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
});

Route::prefix('checkout')->group(function () {
    Route::get('/show/{order}', [CheckoutController::class, 'show'])
        ->name('checkout.show');
});

Route::prefix('payment')->group(function () {

    Route::post('pay/{order}', [\App\Http\Controllers\PaymentController::class, 'pay'])
        ->name('payment.pay');

    Route::get('call-back', [\App\Http\Controllers\PaymentController::class, 'callBack'])
        ->name('payment.callBack');

    Route::get('/success/{payment}', [\App\Http\Controllers\PaymentController::class, 'showPaymentSuccessResult'])
        ->name('payment.success');

    Route::get('/failed/{errorMessage?}', [\App\Http\Controllers\PaymentController::class, 'showPaymentFailedResult'])
        ->name('payment.failed');
});
