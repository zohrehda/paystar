<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
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

Route::redirect('/', 'login');

Route::get('/login', function () {
    return view('home');
});
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->middleware('auth');
Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->middleware('auth')->name('checkout.callback');
Route::get('/checkout/status/{transaction_id}', [CheckoutController::class, 'status'])
    ->middleware('auth')
    ->name('checkout.status');
