# 02. Persiapan Hosting & Topologi Deployment

Dokumen ini membandingkan jenis hosting dan merinci topologi infrastruktur Kosan SaaS untuk menjamin skalabilitas tinggi.

---

## 1. Perbandingan Jenis Hosting

| Jenis Hosting | Skalabilitas | Multi-Tenant Suitability | Rekomendasi |
| :--- | :--- | :--- | :--- |
| **Shared Hosting** | Sangat Rendah | Tidak Cocok (Limitasi port & daemon) | ❌ **Tidak Disarankan** |
| **VPS / Cloud VPS** | Tinggi | Sangat Cocok (Akses Root penuh) |  **Sangat Disarankan** |
| **Dedicated Server**| Sangat Tinggi | Cocok untuk skala masif | Opsional |

---

## 2. Topologi Infrastruktur Rekomendasi

Pada lingkungan produksi enterprise, disarankan membagi server menjadi beberapa bagian demi stabilitas sistem:

```
[ DNS Wildcard (*.kosan.my.id) ]
               │
               ▼
[ Load Balancer (Nginx / Cloudflare SSL) ]
               │
               ▼
      ┌────────┴────────┐
      ▼                 ▼
[ App Server 1 ]  [ App Server 2 ]  <─── (Nginx + PHP-FPM)
      │                 │
      └────────┬────────┘
               ▼
   ┌───────────┴───────────┐
   ▼                       ▼
[ Redis Cache & Queue ] [ MySQL Primary DB ]
```

### Penjelasan Komponen:
1. **Reverse Proxy / Load Balancer**: Menerima request HTTPS dari client, memverifikasi sertifikat SSL, dan meneruskan trafik ke server aplikasi.
2. **App Servers (PHP-FPM)**: Memproses logika aplikasi Laravel secara stateless.
3. **Database Server (MySQL)**: Server khusus terpisah untuk MySQL untuk mencegah rebutan RAM dengan aplikasi PHP.
4. **Redis Server**: Menangani cache sesi, rate limiter, dan antrean job agar antrean background tidak membebani database utama.
