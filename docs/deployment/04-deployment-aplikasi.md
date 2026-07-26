# 04. Panduan Deployment Aplikasi

Langkah deployment berkode aplikasi Kosan SaaS ke server produksi yang sudah dikonfigurasi.

---

## 1. Kloning Repositori
Masuk ke direktori web server, klon repositori Anda, dan atur kepemilikan folder:
```bash
cd /var/www
git clone https://github.com/username/kosan.git
cd kosan
```

---

## 2. Instalasi Dependensi & Build Assets
```bash
# Dependencies PHP
composer install --no-dev --optimize-autoloader --no-interaction

# Dependencies Front-end
npm install
npm run build
```

---

## 3. Konfigurasi File Environment
Salin template `.env.example` ke `.env`:
```bash
cp .env.example .env
nano .env
```
Sesuaikan parameter database, mail, redis, dan set `APP_DEBUG=false`, `APP_ENV=production`.

---

## 4. Generate Application Key & Symlink Storage
```bash
php artisan key:generate --force
php artisan storage:link
```

---

## 5. Jalankan Migrasi Database & Seeds
```bash
php artisan migrate --force
php artisan db:seed --class=RolesAndPermissionsSeeder --force
php artisan db:seed --class=SaasPlansSeeder --force
php artisan db:seed --class=CmsSeeder --force
```

---

## 6. Optimasi Cache Laravel
Jalankan caching semua konfigurasi untuk performa loading maksimal di server produksi:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## 7. Konfigurasi Kepemilikan Berkas
Pastikan web server (www-data) memiliki hak akses penuh ke folder storage dan cache:
```bash
sudo chown -R www-data:www-data /var/www/kosan
sudo chmod -R 775 /var/www/kosan/storage
sudo chmod -R 775 /var/www/kosan/bootstrap/cache
```
