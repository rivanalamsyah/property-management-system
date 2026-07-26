# 08. Konfigurasi SSL (HTTPS Let's Encrypt)

Mengamankan trafik data platform Kosan SaaS menggunakan sertifikat TLS/SSL Let's Encrypt secara gratis.

---

## 1. Instalasi Certbot Nginx
```bash
sudo apt install certbot python3-certbot-nginx -y
```

---

## 2. Meminta Sertifikat SSL Wildcard
Karena platform menggunakan subdomain dinamis untuk tiap tenant (`*.kosan.my.id`), kita harus membuat sertifikat bertipe wildcard:
```bash
sudo certbot certonly --manual --preferred-challenges=dns -d kosan.my.id -d *.kosan.my.id
```
Ikuti instruksi layar untuk menambahkan TXT Record baru pada DNS management domain Anda sebagai langkah pembuktian kepemilikan domain.

---

## 3. Konfigurasi Auto-Renewal
Let's Encrypt berlaku selama 90 hari. Tambahkan cron job untuk memperbaruinya secara otomatis:
```bash
sudo certbot renew --dry-run
```
Proses ini biasanya sudah dipasang secara otomatis di `/etc/cron.d/certbot` saat instalasi.
