<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Models\Product;
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

Route::get('/', [ProductController::class, 'index']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);

Route::put('/users/{id}', [UserController::class, 'update']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/products/{id}/ratings', [RatingController::class, 'store']);

Route::post('/products/{id}/comments', [CommentController::class, 'store']);
Route::put('/products/{product_id}/comments/{comment_id}', [CommentController::class, 'update']);
Route::delete('/products/{product_id}/comments/{comment_id}', [CommentController::class, 'destroy']);

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
