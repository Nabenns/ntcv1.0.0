<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Override public_path() untuk Opsi 2 deployment (isi public dikeluarkan ke root)
        // Cek apakah PUBLIC_PATH constant sudah di-set (dari index.php)
        if (defined('PUBLIC_PATH')) {
            $this->app->bind('path.public', function () {
                return PUBLIC_PATH;
            });
        } elseif (is_dir(base_path('../laravel')) && file_exists(base_path('../index.php'))) {
            // Auto-detect Opsi 2: ada folder laravel dan index.php di parent
            $this->app->bind('path.public', function () {
                return base_path('..');
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
