# 03. Panduan Instalasi Server

Panduan langkah demi langkah untuk melakukan instalasi seluruh dependensi pada server Ubuntu 22.04 LTS dari awal.

---

## 1. Pembaruan Paket Sistem
Hubungkan ke server via SSH, kemudian jalankan pembaruan repositori apt:
```bash
sudo apt update && sudo apt upgrade -y
```

---

## 2. Instalasi PHP 8.3 & Ekstensi
Tambahkan repositori PPA Ondrej PHP untuk mendapatkan versi terbaru:
```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP FPM dan modul pendukung
sudo apt install php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-gd php8.3-redis -y
```

Verifikasi instalasi PHP:
```bash
php -v
```

---

## 3. Instalasi Web Server Nginx
```bash
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
```

---

## 4. Instalasi Database MySQL 8.0
```bash
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql
```

Amankan instalasi MySQL dengan menjalankan script keamanan:
```bash
sudo mysql_secure_installation
```

---

## 5. Instalasi Redis Server
```bash
sudo apt install redis-server -y
sudo systemctl start redis-server
sudo systemctl enable redis-server
```

---

## 6. Instalasi Composer & NodeJS
```bash
# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# NodeJS & NPM
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y
```

---

## 7. Konfigurasi UFW Firewall
```bash
sudo ufw allow OpenSSH
sudo ufw allow "Nginx Full"
sudo ufw enable
```
