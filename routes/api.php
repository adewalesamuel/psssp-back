<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ApiUserAuthController;
use App\Http\Controllers\Auth\ApiAdminAuthController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\FileUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/{country}', [CountryController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::post('login', [ApiUserAuthController::class, 'login']);
Route::post('register', [ApiUserAuthController::class, 'register']);

Route::middleware(['auth.api_token:user'])->group(function () {
    Route::post('logout', [ApiUserAuthController::class, 'logout']);
    Route::post('validate', [UserController::class, 'account_validate']);

    Route::get('analytics', [UserController::class, 'account_analytics']);

    Route::get('profile', [UserController::class, 'account_show']);
    Route::put('profile', [UserController::class, 'account_update']);

    Route::put('password', [UserController::class, 'account_password']);

    Route::get('products', [ProductController::class, 'account_index']);
    Route::get('products/{slug}', [ProductController::class, 'account_show']);
    Route::post('products', [ProductController::class, 'account_store']);
    Route::put('products/{product}', [ProductController::class, 'account_update']);
    Route::delete('products/{id}', [ProductController::class, 'delete']);

    Route::get('orders', [OrderController::class, 'account_index']);
    Route::post('orders', [OrderController::class, 'account_store']);
    Route::put('orders', [OrderController::class, 'account_update']);

    Route::post('upload', [FileUploadController::class, 'store']);
});

Route::prefix('admin')->group(function() {
    Route::post('login', [ApiAdminAuthController::class, 'login']);
    Route::post('logout', [ApiAdminAuthController::class, 'logout']);

    Route::middleware(['auth.api_token:admin'])->group(function () {
        Route::post('upload', [FileUploadController::class, 'store']);

        Route::get('countries', [CountryController::class, 'index']);
        Route::get('countries/{country}', [CountryController::class, 'show']);
        Route::post('countries', [CountryController::class, 'store']);
        Route::put('countries/{country}', [CountryController::class, 'update']);
        Route::delete('countries/{country}', [CountryController::class, 'destroy']);

        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/{category}', [CategoryController::class, 'show']);
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

        Route::get('users', [UserController::class, 'index']);
        Route::post('users', [UserController::class, 'store']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);

        Route::get('products', [ProductController::class, 'index']);
        Route::post('products', [ProductController::class, 'store']);
        Route::get('products/{product}', [ProductController::class, 'show']);
        Route::put('products/{product}', [ProductController::class, 'update']);
        Route::delete('products/{product}', [ProductController::class, 'destroy']);

        Route::get('orders', [OrderController::class, 'index']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::put('orders/{order}', [OrderController::class, 'update']);
        Route::delete('orders/{order}', [OrderController::class, 'destroy']);

        Route::get('permissions', [PermissionController::class, 'index']);
        Route::post('permissions', [PermissionController::class, 'store']);
        Route::get('permissions/{permission}', [PermissionController::class, 'show']);
        Route::put('permissions/{permission}', [PermissionController::class, 'update']);
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy']);

        Route::get('roles', [RoleController::class, 'index']);
        Route::post('roles', [RoleController::class, 'store']);
        Route::get('roles/{role}', [RoleController::class, 'show']);
        Route::put('roles/{role}', [RoleController::class, 'update']);
        Route::delete('roles/{role}', [RoleController::class, 'destroy']);

        Route::get('admins', [AdminController::class, 'index']);
        Route::post('admins', [AdminController::class, 'store']);
        Route::get('admins/{admin}', [AdminController::class, 'show']);
        Route::put('admins/{admin}', [AdminController::class, 'update']);
        Route::delete('admins/{admin}', [AdminController::class, 'destroy']);

        Route::get('ebooks', [EbookController::class, 'index']);
        Route::post('ebooks', [EbookController::class, 'store']);
        Route::get('ebooks/{ebook}', [EbookController::class, 'show']);
        Route::put('ebooks/{ebook}', [EbookController::class, 'update']);
        Route::delete('ebooks/{ebook}', [EbookController::class, 'destroy']);
    });

});


