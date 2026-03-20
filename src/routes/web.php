<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/', [ProductController::class, 'index']);
// 検索
Route::get('/products/search', [ProductController::class, 'index'])->name('products.search');
// 商品登録
Route::get('/products/register', [ProductController::class, 'create'])->name('products.register');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');
// 商品詳細
Route::get('/products/detail/{productId}', [ProductController::class, 'show'])->name('products.detail');
// 商品更新
Route::patch('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');
// 削除
Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
