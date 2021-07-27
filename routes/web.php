<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/test', [HomeController::class, 'test'])->name('test');

Route::get('/alo', [HomeController::class, 'alo']);
Route::post('/alo', [HomeController::class, 'alo'])->name('alo');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
    });
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::post('status', [PostController::class, 'switchStatus'])->name('switch_status');
        Route::delete('{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::get('{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('{post}', [PostController::class, 'update'])->name('update');
    });
});


require __DIR__.'/auth.php';
