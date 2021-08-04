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

// CART
Route::get('/cart', [CartController::class, 'index']);
Route::post('/carts', [CartController::class, 'store']);
Route::put('/carts/{id}', [CartController::class, 'update']);
Route::delete('/carts/{id}', [CartController::class, 'destroy']);
Route::delete('/carts2/{id}', [CartController::class, 'destroy2']);

// USERS
Route::put('/users/{id}', [UserController::class, 'update']);

// PRODUCTS
Route::get('/products/{id}', [ProductController::class, 'show']);

// RATINGS
Route::post('/ratings', [RatingController::class, 'store']);
Route::put('/ratings/{id}', [RatingController::class, 'update']);

// COMMENTS
Route::post('/comments', [CommentController::class, 'store']);
Route::put('/comments/{comment_id}', [CommentController::class, 'update']);
Route::delete('/comments/{comment_id}', [CommentController::class, 'destroy']);

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
