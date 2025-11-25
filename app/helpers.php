<?php

/**
 * Override public_path() helper untuk Opsi 2 deployment
 * 
 * File ini di-load di index.php SETELAH vendor/autoload.php
 * Tapi SEBELUM Laravel bootstrap/app.php
 * 
 * Dengan Opsi 2, isi folder public dikeluarkan ke root public_html,
 * jadi public_path() harus mengarah ke root, bukan laravel/public
 * 
 * Catatan: Laravel helpers di-load saat bootstrap, jadi kita bisa override
 * dengan mendefinisikan ulang function ini.
 */

// Hapus function yang sudah ada jika ada (dari Laravel)
if (function_exists('public_path')) {
    // Kita tidak bisa menghapus function yang sudah didefinisikan
    // Tapi kita bisa override dengan namespace atau menggunakan binding
    // Untuk sekarang, kita akan mengandalkan binding di AppServiceProvider
    // dan memastikan constant PUBLIC_PATH digunakan
}

// Definisikan function baru (akan override jika Laravel belum load helpers)
if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        // Prioritas 1: Gunakan PUBLIC_PATH constant dari index.php
        if (defined('PUBLIC_PATH')) {
            return rtrim(PUBLIC_PATH, '/') . ($path ? '/' . ltrim($path, '/') : '');
        }
        
        // Prioritas 2: Auto-detect Opsi 2
        // base_path() akan mengarah ke laravel/, jadi kita perlu naik 1 level
        $basePath = dirname(__DIR__);
        if (is_dir($basePath . '/../laravel') && file_exists($basePath . '/../index.php')) {
            return rtrim($basePath . '/..', '/') . ($path ? '/' . ltrim($path, '/') : '');
        }
        
        // Default: Laravel behavior (untuk development)
        return rtrim($basePath . '/public', '/') . ($path ? '/' . ltrim($path, '/') : '');
    }
}

