# 10. Konfigurasi Backup & Recovery

Strategi pencadangan data otomatis untuk menjamin Business Continuity (BCDR) platform Kosan SaaS jika terjadi bencana kegagalan hardware.

---

## 1. Script Backup Database (`backup.sh`)
Buat script shell sederhana di direktori aman server (misal `/root/backup.sh`):
```bash
#!/bin/bash
BACKUP_DIR="/var/www/kosan/storage/app/backups"
DB_NAME="kosan"
DATE=$(date +%Y%m%d_%H%M%S)

# Dump database MySQL
mysqldump -u root -p'PasswordDBAnda' $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# Hapus backup yang lebih tua dari 30 hari (Retention)
find $BACKUP_DIR -type f -name "*.sql.gz" -mtime +30 -delete
```

Jadikan file executable dan jadwalkan di crontab root:
```bash
chmod +x /root/backup.sh
```

---

## 2. Alur Pemulihan (Recovery)
Apabila terjadi bencana, pulihkan database menggunakan file dump:
```bash
gunzip < /var/www/kosan/storage/app/backups/db_backup_xxxx.sql.gz | mysql -u root -p kosan
```
