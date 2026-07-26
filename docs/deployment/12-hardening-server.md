# 12. Keamanan Server (Hardening)

Langkah-langkah tambahan untuk memperkuat sistem operasi server dari potensi serangan peretasan siber.

---

## 1. SSH Hardening (`/etc/ssh/sshd_config`)
Amankan akses SSH ke server:
```ini
# Nonaktifkan login SSH menggunakan user root langsung
PermitRootLogin no

# Ubah port default SSH untuk menghindari brute-force scanning bot
Port 22022

# Nonaktifkan autentikasi password jika memungkinkan, gunakan SSH Key
PasswordAuthentication no
```
Terapkan perubahan dengan me-restart daemon SSH:
```bash
sudo systemctl restart ssh
```

---

## 2. Instalasi Fail2ban
Fail2ban mendeteksi aktivitas percobaan login mencurigakan dan memblokir IP penyerang secara otomatis via IPtables:
```bash
sudo apt install fail2ban -y
sudo systemctl start fail2ban
sudo systemctl enable fail2ban
```

---

## 3. Izin Akses Berkas yang Ketat
Pastikan berkas sensitif `.env` tidak dapat dibaca oleh pengguna umum server:
```bash
chmod 600 /var/www/kosan/.env
```
