<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\PostController;
use App\Http\Controllers\API\V1\CustomerController;
use App\Http\Controllers\API\V1\InvoiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('posts', PostController::class);

// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\V1'], function () {
    Route::apiResource('customers', CustomerController::class);

    Route::apiResource('invoices', InvoiceController::class);

    Route::get('/posts/statistics', [PostController::class, 'statistics'])->name('posts.statistics');
    Route::get('/posts/test-sql-injection-post', [PostController::class, 'testSqlInjectionPost'])->name('posts.test-sql-injection-post');
    Route::apiResource('posts', PostController::class);
});
