# 06. Konfigurasi Supervisor (Queue Workers)

Supervisor bertugas memantau dan menjaga agar background queue workers Laravel tetap berjalan secara konsisten di server produksi.

---

## 1. Pembuatan File Konfigurasi Supervisor
Buat file konfigurasi `/etc/supervisor/conf.d/kosan-worker.conf`:
```ini
[program:kosan-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/kosan/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/kosan/storage/logs/worker.log
stopwaitsecs=3600
```

---

## 2. Menjalankan Supervisor
Jalankan perintah berikut untuk memuat ulang konfigurasi dan mengaktifkan worker:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl status
```

---

## 3. Strategi Restart saat Deployment
Pastikan worker di-restart setiap kali kode program diperbarui agar menggunakan cache kode terbaru:
```bash
sudo supervisorctl restart kosan-worker:*
```
