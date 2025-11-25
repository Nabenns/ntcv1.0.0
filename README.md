# Nusantara Trading Center (NTC) v1.0.0

Website resmi Nusantara Trading Center - Pusat informasi layanan, artikel edukasi trading, dan panel admin untuk mengelola konten.

## 🚀 Fitur Utama

- **Frontend Marketing**: Landing page dengan dark mode, ticker real-time, dan desain modern
- **Blog/Artikel**: Sistem artikel dengan CRUD lengkap, upload gambar, dan SEO-friendly slugs
- **Admin Panel**: Panel admin menggunakan Filament PHP untuk mengelola konten
- **Real-time Ticker**: Integrasi dengan Finnhub API untuk data pasar real-time
- **Responsive Design**: Desain yang responsif dan mobile-friendly

## 📋 Requirements

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM (untuk asset compilation)
- MySQL/PostgreSQL (SQLite untuk development)
- Extension PHP: `pdo_sqlite`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl`, `fileinfo`, `gd`

## 🛠️ Installation (Local Development)

1. **Clone repository**
   ```bash
   git clone https://github.com/Nabenns/ntcv1.0.0.git
   cd ntcv1.0.0
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database di `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ntc_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Setup Finnhub API Key (untuk ticker real-time)**
   ```env
   FINNHUB_API_KEY=your_finnhub_api_key_here
   ```

6. **Jalankan migrations dan seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Setup storage link**
   ```bash
   php artisan storage:link
   ```

8. **Compile assets**
   ```bash
   npm run build
   # atau untuk development dengan hot reload:
   npm run dev
   ```

9. **Jalankan server**
   ```bash
   php artisan serve
   ```

10. **Akses aplikasi**
    - Frontend: http://localhost:8000
    - Admin Panel: http://localhost:8000/admin
    - Login Admin:
      - Email: `admin@ntc.local`
      - Password: `password`

## 📦 Deployment ke Niagahoster

### Persiapan di Server (via SSH)

1. **SSH ke server Niagahoster**
   ```bash
   ssh username@your-domain.com
   ```

2. **Masuk ke direktori public_html atau www**
   ```bash
   cd public_html
   # atau
   cd www
   ```

3. **Clone repository (jika belum)**
   ```bash
   git clone https://github.com/Nabenns/ntcv1.0.0.git .
   # atau jika sudah ada, pull update:
   git pull origin main
   ```

4. **Install dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

5. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

6. **Edit file `.env` dengan konfigurasi production**
   ```env
   APP_NAME="Nusantara Trading Center"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=nama_database_niagahoster
   DB_USERNAME=username_database_niagahoster
   DB_PASSWORD=password_database_niagahoster

   FINNHUB_API_KEY=your_finnhub_api_key_here
   ```

7. **Jalankan migrations**
   ```bash
   php artisan migrate --force
   ```

8. **Setup storage link**

   **Opsi 1: Menggunakan Artisan (jika fungsi exec() tersedia)**
   ```bash
   php artisan storage:link
   ```

   **Opsi 2: Membuat symlink secara manual (jika exec() dinonaktifkan)**
   ```bash
   # Pastikan berada di direktori public_html
   cd ~/public_html
   
   # Hapus folder storage jika sudah ada
   rm -rf public/storage
   
   # Buat symbolic link secara manual
   ln -s ../storage/app/public public/storage
   
   # Atau jika struktur berbeda, coba:
   ln -s ../../storage/app/public public/storage
   
   # Verifikasi symlink berhasil
   ls -la public/storage
   ```

   **Catatan**: Jika symlink tidak bisa dibuat, aplikasi akan otomatis menggunakan route fallback untuk serve file dari storage.

9. **Setup Vite manifest (untuk Opsi 2 deployment)**

   Jika menggunakan Opsi 2 (isi public dikeluarkan ke root), buat symlink untuk manifest.json:
   ```bash
   cd ~/public_html/laravel
   
   # Buat folder public/build jika belum ada
   mkdir -p public/build
   
   # Buat symlink manifest.json dari root ke laravel/public/build
   ln -s ../../build/manifest.json public/build/manifest.json
   
   # Atau copy file jika symlink tidak bisa dibuat
   cp ../build/manifest.json public/build/manifest.json
   cp -r ../build/assets public/build/
   ```

9. **Optimize untuk production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

10. **Set permissions**
    ```bash
    chmod -R 755 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache
    ```

### Konfigurasi Web Server

**Untuk Apache (.htaccess sudah tersedia di `public/.htaccess`)**

Pastikan `DocumentRoot` mengarah ke folder `public`:
```
DocumentRoot /home/username/public_html/public
```

**Untuk Nginx**, tambahkan konfigurasi:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /home/username/public_html/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Setup Database di Niagahoster

1. Login ke cPanel Niagahoster
2. Buat database MySQL baru
3. Buat user database dan berikan akses ke database tersebut
4. Update informasi database di file `.env`

## 🔐 Admin Panel Access

- **URL**: `https://your-domain.com/admin`
- **Default Login**:
  - Email: `admin@ntc.local`
  - Password: `password`

**⚠️ PENTING**: Segera ubah password admin setelah deployment pertama!

## 📁 Struktur Project

```
ntc/
├── app/
│   ├── Filament/          # Filament Admin Panel Resources
│   ├── Http/
│   │   ├── Controllers/   # Controllers
│   │   └── Api/           # API Controllers (Ticker)
│   └── Models/            # Eloquent Models
├── database/
│   ├── migrations/        # Database Migrations
│   ├── seeders/           # Database Seeders
│   └── factories/         # Model Factories
├── public/                # Public assets (DocumentRoot)
├── resources/
│   ├── views/             # Blade Templates
│   ├── css/               # CSS Files
│   └── js/                # JavaScript Files
├── routes/
│   └── web.php            # Web Routes
└── storage/               # Storage untuk uploads
```

## 🔧 Troubleshooting

### Ticker menampilkan "N/A"
- Pastikan `FINNHUB_API_KEY` sudah di-set di `.env`
- Pastikan API key valid dan aktif
- Clear cache: `php artisan config:clear`

### Gambar tidak muncul setelah upload
- Pastikan `php artisan storage:link` sudah dijalankan
- Pastikan folder `storage/app/public` memiliki permission yang benar
- Pastikan `APP_URL` di `.env` sesuai dengan domain yang digunakan

### Error 500 setelah deployment
- Pastikan semua dependencies terinstall: `composer install --no-dev`
- Pastikan `.env` sudah dikonfigurasi dengan benar
- Check log: `storage/logs/laravel.log`
- Pastikan permissions folder `storage` dan `bootstrap/cache` sudah benar

## 📝 License

Proprietary - Nusantara Trading Center

## 👥 Support

Untuk pertanyaan dan support, hubungi:
- Telegram: [@nusantaratradingcentral](https://t.me/nusantaratradingcentral)
- Instagram: [@nusantaratradingcentral](https://www.instagram.com/nusantaratradingcentral)
