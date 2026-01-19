<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestAgoraController;
use App\Http\Controllers\ZoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return 'Hello World';
});

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    Route::post('store-zone',[ZoneController::class, 'store']);
    Route::post('store-area',[AreaController::class, 'store']);
    Route::post('store-loaction',[LocationController::class, 'store']);

    Route::get('all-categories',[CategorieController::class, 'index']);
    Route::post('store-categories',[CategorieController::class, 'store']);
    Route::get('one-categore/{id}',[CategorieController::class, 'show']
    );
    Route::get('all-products',[ProductController::class, 'index']);
    Route::post('store-product',[ProductController::class, 'store']);
    Route::get('one-product/{id}',[CategorieController::class, 'show']);
    Route::get('products-of-categore',[ProductController::class, 'productOFcategore']);

    Route::post('addToCart', [CartController::class, 'addToCart']);
    Route::Delete('delete-cart-product/{product_id}', [CartController::class, 'destroy']);

    Route::post('create-order', [OrderController::class, 'CreateOrder']);
    Route::Delete('remove-order/{order_id}', [OrderController::class, 'removeorder']);

    Route::post('change-password', [PasswordController::class, 'changePassword']);
});
Route::post('forgot-password', [PasswordController::class, 'sendResetCode']);
Route::post('verify-reset-code', [PasswordController::class, 'verifyResetCode']); // التحقق من كود OTP
Route::post('reset-password', [PasswordController::class, 'resetPassword']); // تحديث كلمة المرور


Route::get('agora', [TestAgoraController::class, 'getAgoraToken']);
