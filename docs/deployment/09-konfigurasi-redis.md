# 09. Konfigurasi Redis Server

Redis digunakan sebagai backend cache, antrean (queue), dan session driver berkecepatan tinggi pada Kosan SaaS.

---

## 1. Mengamankan Redis (`/etc/redis/redis.conf`)
Buka konfigurasi Redis, dan batasi akses serta aktifkan password:
```ini
bind 127.0.0.1 ::1
requirepass PasswordKuatRedisAndaDisini
```
Restart Redis untuk menerapkan perubahan:
```bash
sudo systemctl restart redis-server
```

---

## 2. Konfigurasi Laravel `.env`
Sesuaikan kredensial di aplikasi Laravel:
```env
CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=PasswordKuatRedisAndaDisini
REDIS_PORT=6379
```
