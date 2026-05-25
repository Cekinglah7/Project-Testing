<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\NomerAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LocationController;

Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook/redirect', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::post('/login/google', [SocialAuthController::class, 'loginGoogleApi']);
Route::post('/login/facebook', [SocialAuthController::class, 'loginFacebookApi']);

Route::post('/send-otp', [NomerAuthController::class, 'sendOtp']);
Route::post('/verify-otp', [NomerAuthController::class, 'verifyOtp']);

Route::get('/zones', [LocationController::class, 'zones']);
Route::get('/areas', [LocationController::class, 'areas']);

Route::get('/home', [HomeController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [SocialAuthController::class, 'logoutApi']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/reduce', [CartController::class, 'removeFromCart']);
    Route::post('/cart/add-all-favorites', [CartController::class, 'addAllFavorites']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle']);
    Route::get('/notifications', [NotificationController::class, 'index']); 
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
