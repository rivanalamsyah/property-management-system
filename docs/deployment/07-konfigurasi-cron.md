# 07. Konfigurasi Cron (Laravel Scheduler)

Laravel Scheduler membutuhkan satu entri cron di tingkat sistem operasi untuk memicu eksekusi tugas terjadwal (tagihan otomatis, denda overdue, backup, dll).

---

## 1. Mendaftarkan Cron Job
Jalankan perintah berikut untuk mengedit cron job milik user `www-data`:
```bash
sudo crontab -e -u www-data
```

Tambahkan baris berikut di bagian paling bawah file:
```cron
* * * * * php /var/www/kosan/artisan schedule:run >> /dev/null 2>&1
```

---

## 2. Verifikasi Scheduler
Untuk memastikan scheduler bekerja secara lokal, Anda dapat menjalankan perintah uji coba:
```bash
php artisan schedule:list
```
Perintah di atas akan menampilkan seluruh tugas terjadwal (seperti trial check, invoicing bulanan, log pruning, dan auto-backup) beserta jadwal eksekusinya.
