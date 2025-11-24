<?php

use App\Http\Controllers\Api\TickerController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/article/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/ticker', [TickerController::class, 'index'])->name('api.ticker');
});
