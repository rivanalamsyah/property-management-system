# 11. Monitoring & Observabilitas Server

Memastikan performa server tetap stabil dan mendeteksi anomali penggunaan resource secara dini.

---

## 1. Monitoring Resources dengan CLI
* **CPU & RAM**: Gunakan command `htop` untuk memantau beban CPU dan memori per proses.
* **Disk I/O**: Gunakan `df -h` untuk memastikan memori penyimpanan disk tidak penuh.

---

## 2. Pemantauan Logs Aplikasi
Pantau log kesalahan Laravel secara real-time untuk penanganan bug cepat:
```bash
tail -f /var/www/kosan/storage/logs/laravel.log
```

---

## 3. Observabilitas Dashboard SRE
Gunakan modul terintegrasi di Admin Dashboard (/dashboard/monitoring) untuk meninjau:
* Rata-rata latensi HTTP request P95 & P99.
* Indikator antrean (Queue) job yang macet.
* Metrik log pengecualian (Exception) sistem secara visual.
