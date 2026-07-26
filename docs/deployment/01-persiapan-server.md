# 01. Persiapan Server

Dokumen ini menjelaskan persyaratan minimum dan rekomendasi spesifikasi server untuk menjalankan aplikasi Kosan SaaS pada lingkungan produksi.

---

## 1. Spesifikasi Server

### Spesifikasi Minimum (Hingga 50 Tenant / 1.000 Resident)
* **CPU**: 2 Core vCPU (Intel Xeon / AMD EPYC)
* **RAM**: 4 GB DDR4
* **Penyimpanan**: 40 GB SSD (NVMe disarankan)
* **Sistem Operasi**: Ubuntu 22.04 LTS / Ubuntu 24.04 LTS (64-bit)

### Spesifikasi Rekomendasi (50+ Tenant / 5.000+ Resident)
* **CPU**: 4 Core vCPU atau lebih
* **RAM**: 8 GB DDR4 / DDR5
* **Penyimpanan**: 80 GB atau lebih NVMe SSD
* **Sistem Operasi**: Ubuntu 22.04 LTS

---

## 2. Pilihan Web Server

* **Nginx (Rekomendasi)**: Dipilih karena efisiensi memori yang tinggi, penanganan berkas statis yang cepat, dan kemampuan bertindak sebagai reverse proxy yang andal untuk PHP-FPM.
* **Apache**: Alternatif lain, namun membutuhkan konsumsi RAM yang lebih tinggi saat menangani banyak request simultan.

---

## 3. Komponen Perangkat Lunak Produksi

* **PHP**: Versi 8.3 dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `xml`, `curl`, `zip`, `gd`, `redis`.
* **Database**: MySQL 8.0 / MariaDB 10.6+ dengan dukungan engine InnoDB.
* **Caching & Queue**: Redis Server 6.2+ untuk performa antrean kerja (queue) asinkron dan session storage.
* **Process Manager**: Supervisor untuk memastikan background queue worker Laravel berjalan tanpa henti.
* **Cron Daemon**: Untuk memicu sistem penjadwalan Laravel (*Scheduler*) setiap menit.
* **SSL Certificate**: Let's Encrypt TLS v1.3 untuk enkripsi data HTTPS.

---

## 4. Persyaratan Jaringan & Domain

* **Domain Utama**: `kosan.my.id` (Contoh) untuk landing page pemasaran dan akses global.
* **Wildcard Subdomain**: `*.kosan.my.id` wajib dikonfigurasi pada DNS record (A Record mengarah ke IP Server) untuk mendukung modul workspace multi-tenant dinamis.
* **Port Terbuka**:
  * `22/TCP` (SSH Access)
  * `80/TCP` (HTTP redirect)
  * `443/TCP` (HTTPS Secure)
