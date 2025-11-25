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

// Storage file serving (fallback jika symlink tidak bisa dibuat)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $file = file_get_contents($filePath);
    $type = mime_content_type($filePath);
    
    return response($file, 200)->header('Content-Type', $type);
})->where('path', '.*')->name('storage.serve');
