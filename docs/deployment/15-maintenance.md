# 15. Pemeliharaan Rutin Server (Maintenance)

Prosedur berkala untuk menjaga stabilitas dan keamanan platform Kosan SaaS jangka panjang.

---

## 1. Pembaruan Kode Aplikasi Berkala
Saat merilis versi baru, ikuti prosedur berikut:
```bash
cd /var/www/kosan
php artisan down
git pull origin main
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan optimize
sudo supervisorctl restart kosan-worker:*
php artisan up
```

---

## 2. Pembaruan Keamanan Sistem Operasi
Lakukan pembaruan patch OS secara berkala setiap bulan:
```bash
sudo apt update && sudo apt upgrade -y
```

---

## 3. Pemantauan Ukuran Disk Space
Bersihkan log lama dan cache database secara berkala agar penyimpanan server tidak penuh:
```bash
php artisan log:clear
php artisan cache:clear
```
