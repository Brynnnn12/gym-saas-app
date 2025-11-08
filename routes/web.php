<?php

use App\Http\Controllers\Frontend\GymController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\AuthController;
use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('/', [GymController::class, 'home'])->name('home');
Route::get('/gyms', [GymController::class, 'index'])->name('gyms.index');
Route::get('/gyms/{slug}', [GymController::class, 'show'])->name('gyms.show');

// Member Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('member.login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('member.register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('member.logout');

// Checkout routes
Route::get('/checkout/{plan}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{plan}', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/thank-you', [CheckoutController::class, 'thankYou'])->name('checkout.thank-you');

// Midtrans callback (exclude from CSRF)
Route::post('/midtrans/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');
