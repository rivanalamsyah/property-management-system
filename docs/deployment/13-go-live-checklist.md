# 13. Go-Live Checklist

Daftar periksa akhir sebelum meluncurkan aplikasi Kosan SaaS ke publik.

---

## Checklist Uji Coba Produksi:

* [ ] Kredensial `.env` menggunakan kata sandi unik dan aman di produksi.
* [ ] Parameter `APP_DEBUG` bernilai `false`.
* [ ] Sertifikat SSL Let's Encrypt wildcard aktif dan HTTPS dipaksa redirect.
* [ ] Port firewall selain 80, 443, dan port SSH kustom ditutup.
* [ ] Daemon Supervisor aktif memantau queue workers.
* [ ] Cron Laravel Scheduler berjalan aktif di crontab www-data.
* [ ] Link storage (`public/storage`) berhasil terhubung dan dapat diakses.
* [ ] Keamanan Redis password terkonfigurasi di `redis.conf`.
* [ ] Seluruh cache produksi (config, route, view) berhasil digenerasi.
* [ ] Uji coba backup database & restore manual berhasil lolos validasi checksum.
