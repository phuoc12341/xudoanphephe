<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'getAllCategory'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::post('status', [CategoryController::class, 'switchStatus'])->name('switch_status');
        Route::delete('{id}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::patch('{id}', [CategoryController::class, 'update'])->name('update');
    });
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::post('status', [PostController::class, 'switchStatus'])->name('switch_status');
        Route::delete('{id}', [PostController::class, 'destroy'])->name('destroy');
    });
});
