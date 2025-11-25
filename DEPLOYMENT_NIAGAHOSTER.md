# Panduan Deployment ke Niagahoster

## Opsi 1: Set DocumentRoot ke Subfolder (RECOMMENDED)

Ini adalah cara standar dan paling mudah. Semua file Laravel tetap di `public_html`, dan DocumentRoot diarahkan ke `public_html/public`.

### Langkah-langkah:

1. **Upload semua file Laravel ke `public_html`**
   ```bash
   # Via SSH atau File Manager
   # Semua file Laravel (app, bootstrap, config, dll) ada di public_html
   ```

2. **Di cPanel Niagahoster, set DocumentRoot ke subfolder:**
   - Login ke cPanel
   - Cari "Subdomain" atau "Addon Domain" atau "Document Root"
   - Set DocumentRoot ke: `/home/username/public_html/public`
   - Atau jika ada opsi "Change Document Root", pilih folder `public`

3. **Setup seperti biasa:**
   ```bash
   cd ~/public_html
   composer install --optimize-autoloader --no-dev
   cp .env.example .env
   php artisan key:generate
   # ... setup lainnya
   ```

---

## Opsi 2: Keluarkan Isi Folder Public ke Root (Jika Opsi 1 Tidak Bisa)

Jika Niagahoster tidak support set DocumentRoot ke subfolder, gunakan pendekatan ini.

### Struktur Folder yang Diinginkan:

```
public_html/              (Root web server)
├── index.php            (dari public/index.php, path diubah)
├── .htaccess            (dari public/.htaccess)
├── build/               (dari public/build)
├── css/                 (dari public/css)
├── js/                  (dari public/js)
├── fonts/               (dari public/fonts)
├── favicon.ico          (dari public/favicon.ico)
├── robots.txt           (dari public/robots.txt)
├── storage/             (symlink ke laravel/storage/app/public)
└── laravel/             (semua file Laravel lainnya)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    └── ... (file lainnya)
```

### Langkah-langkah:

1. **Buat folder `laravel` di `public_html`**
   ```bash
   cd ~/public_html
   mkdir laravel
   ```

2. **Pindahkan semua file Laravel ke folder `laravel` (kecuali folder `public`)**
   ```bash
   # Pindahkan semua file/folder kecuali public
   mv app bootstrap config database resources routes storage vendor artisan composer.json composer.lock package.json package-lock.json .env.example .gitignore laravel/
   # Juga pindahkan file hidden
   mv .env laravel/ 2>/dev/null || true
   ```

3. **Keluarkan isi folder `public` ke root `public_html`**
   ```bash
   # Pindahkan semua isi public ke root
   mv public/* public/.[^.]* public_html/ 2>/dev/null || true
   mv public/* public_html/
   rmdir public
   ```

4. **Edit file `index.php` di root untuk update path**
   ```php
   <?php
   
   use Illuminate\Foundation\Application;
   use Illuminate\Http\Request;
   
   define('LARAVEL_START', microtime(true));
   
   // Determine if the application is in maintenance mode...
   if (file_exists($maintenance = __DIR__.'/laravel/storage/framework/maintenance.php')) {
       require $maintenance;
   }
   
   // Register the Composer autoloader...
   require __DIR__.'/laravel/vendor/autoload.php';
   
   // Bootstrap Laravel and handle the request...
   /** @var Application $app */
   $app = require_once __DIR__.'/laravel/bootstrap/app.php';
   
   $app->handleRequest(Request::capture());
   ```

5. **Update path di `bootstrap/app.php`** (jika diperlukan)
   ```bash
   # Edit laravel/bootstrap/app.php
   # Pastikan path storage dan bootstrap/cache benar
   ```

6. **Buat symlink storage**
   ```bash
   cd ~/public_html
   ln -s laravel/storage/app/public storage
   ```

7. **Update `.env` untuk path yang benar**
   ```env
   APP_URL=https://your-domain.com
   # Pastikan path storage dan cache benar
   ```

8. **Set permissions**
   ```bash
   chmod -R 755 laravel/storage laravel/bootstrap/cache
   ```

---

## Rekomendasi

**Gunakan Opsi 1** jika memungkinkan karena:
- Lebih mudah dan standar
- Tidak perlu mengubah path di `index.php`
- Struktur folder tetap rapi
- Update lebih mudah (tinggal `git pull`)

**Gunakan Opsi 2** hanya jika:
- Niagahoster tidak support set DocumentRoot ke subfolder
- Atau ada kendala teknis dengan Opsi 1

---

## Verifikasi Setelah Deployment

1. Akses website: `https://your-domain.com`
2. Cek admin panel: `https://your-domain.com/admin`
3. Test upload gambar di admin panel
4. Cek ticker real-time berfungsi
5. Cek artikel bisa diakses

