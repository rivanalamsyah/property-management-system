# 05. Konfigurasi Nginx Web Server

Berikut adalah konfigurasi lengkap server block Nginx untuk menjalankan platform Kosan SaaS di server produksi.

---

## 1. File Konfigurasi `/etc/nginx/sites-available/kosan`

```nginx
server {
    listen 80;
    server_name *.kosan.my.id kosan.my.id;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name *.kosan.my.id kosan.my.id;
    root /var/www/kosan/public;

    ssl_certificate /etc/letsencrypt/live/kosan.my.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/kosan.my.id/privkey.pem;

    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    ssl_ciphers "EECDH+AESGCM:EDH+AESGCM:AES256+EECDH:AES256+EDH";

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Penanganan file asset statis dengan cache tinggi
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|webp|svg|woff|woff2|eot|ttf)$ {
        expires 365d;
        access_log off;
        add_header Cache-Control "public, no-transform";
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

---

## 2. Penjelasan Directive Penting:
* `server_name *.kosan.my.id`: Menangkap semua sub-domain workspace secara dinamis untuk modul multi-tenant.
* `try_files $uri $uri/ /index.php`: Mengarahkan seluruh request URL ke berkas routing utama Laravel (`public/index.php`).
* `expires 365d`: Menginstruksikan browser meng-cache asset statis selama 1 tahun untuk menghemat bandwidth server.
