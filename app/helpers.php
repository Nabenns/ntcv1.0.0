<?php

/**
 * Override public_path() helper untuk Opsi 2 deployment
 * 
 * File ini di-load di index.php SEBELUM vendor/autoload.php
 * Jadi function ini akan didefinisikan SEBELUM Laravel helpers
 * 
 * Dengan Opsi 2, isi folder public dikeluarkan ke root public_html,
 * jadi public_path() harus mengarah ke root, bukan laravel/public
 */

// Definisikan function SEBELUM Laravel helpers di-load
if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        // Prioritas 1: Gunakan PUBLIC_PATH constant dari index.php
        if (defined('PUBLIC_PATH')) {
            return rtrim(PUBLIC_PATH, '/') . ($path ? '/' . ltrim($path, '/') : '');
        }
        
        // Prioritas 2: Auto-detect Opsi 2
        // __DIR__ di helpers.php akan mengarah ke laravel/app/
        // Jadi kita perlu naik 2 level untuk ke root public_html
        $basePath = dirname(__DIR__);
        if (is_dir($basePath . '/../laravel') && file_exists($basePath . '/../index.php')) {
            return rtrim($basePath . '/..', '/') . ($path ? '/' . ltrim($path, '/') : '');
        }
        
        // Default: Laravel behavior (untuk development)
        return rtrim($basePath . '/public', '/') . ($path ? '/' . ltrim($path, '/') : '');
    }
}

