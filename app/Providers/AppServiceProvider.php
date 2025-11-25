<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Override public_path() untuk Opsi 2 deployment (isi public dikeluarkan ke root)
        $customPublicPath = null;
        
        // Cek environment variable dulu
        if (env('APP_PUBLIC_PATH')) {
            $customPublicPath = env('APP_PUBLIC_PATH');
        } elseif (defined('PUBLIC_PATH')) {
            // PUBLIC_PATH constant dari index.php
            $customPublicPath = PUBLIC_PATH;
        } elseif (is_dir(base_path('../laravel')) && file_exists(base_path('../index.php'))) {
            // Auto-detect Opsi 2: ada folder laravel dan index.php di parent
            $customPublicPath = base_path('..');
        }
        
        if ($customPublicPath && is_dir($customPublicPath)) {
            $this->app->singleton('path.public', function () use ($customPublicPath) {
                return $customPublicPath;
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Buat symlink manifest.json jika diperlukan (fallback)
        $defaultPublicPath = base_path('public');
        $customPublicPath = app('path.public') ?? $defaultPublicPath;
        
        if ($customPublicPath !== $defaultPublicPath) {
            $manifestSource = $customPublicPath . '/build/manifest.json';
            $manifestTarget = $defaultPublicPath . '/build/manifest.json';
            
            // Jika manifest ada di custom path tapi tidak di default path, buat symlink
            if (file_exists($manifestSource) && !file_exists($manifestTarget)) {
                $targetDir = dirname($manifestTarget);
                if (!is_dir($targetDir)) {
                    File::makeDirectory($targetDir, 0755, true);
                }
                if (function_exists('symlink')) {
                    @symlink($manifestSource, $manifestTarget);
                } elseif (function_exists('link')) {
                    @link($manifestSource, $manifestTarget);
                }
            }
        }
    }
}
