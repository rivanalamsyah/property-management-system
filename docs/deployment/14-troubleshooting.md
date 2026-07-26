# 14. Panduan Troubleshooting Eror Common

Panduan memecahkan masalah umum yang sering ditemui pada server produksi Laravel.

---

## 1. Masalah Eror "502 Bad Gateway"
* **Penyebab**: Service PHP-FPM mati atau unix socket path di konfigurasi Nginx tidak cocok.
* **Solusi**:
  ```bash
  sudo systemctl restart php8.3-fpm
  sudo systemctl status php8.3-fpm
  ```
  Periksa kecocokan baris `fastcgi_pass unix:/var/run/php/php8.3-fpm.sock` di konfigurasi Nginx.

---

## 2. Masalah Eror "Permission Denied" saat Tulis File
* **Penyebab**: Folder storage atau bootstrap/cache dimiliki oleh user selain `www-data`.
* **Solusi**:
  ```bash
  sudo chown -R www-data:www-data /var/www/kosan/storage
  sudo chmod -R 775 /var/www/kosan/storage
  ```

---

## 3. Masalah Antrean Pekerjaan (Queue) Tidak Berjalan
* **Penyebab**: Supervisor mati atau terhenti.
* **Solusi**:
  ```bash
  sudo systemctl restart supervisor
  sudo supervisorctl restart all
  ```
