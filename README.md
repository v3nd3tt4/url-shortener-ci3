# URL Shortener

Aplikasi URL Shortener yang dibangun dengan CodeIgniter 3. Aplikasi ini memungkinkan pengguna untuk membuat link singkat yang mudah dibagikan dengan fitur analytics dan manajemen URL.

## 🚀 Fitur

### Untuk Pengguna Umum
- ✅ Buat URL singkat tanpa perlu login
- ✅ Custom URL (opsional)
- ✅ Judul dan deskripsi untuk URL
- ✅ QR Code generator otomatis
- ✅ Download QR Code
- ✅ Copy URL ke clipboard
- ✅ Expired date (opsional, default 30 hari)
- ✅ Responsive design

### Untuk Admin
- ✅ Dashboard dengan statistik
- ✅ Manajemen semua URL
- ✅ Edit URL (original URL, custom URL, judul, deskripsi, expired date, status)
- ✅ Hapus URL
- ✅ Copy URL dari dashboard
- ✅ Filter dan pencarian URL
- ✅ Analytics klik per URL
- ✅ Status URL (Aktif/Nonaktif/Expired)

## 🛠️ Teknologi

- **Backend**: CodeIgniter 3
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, jQuery, Font Awesome
- **QR Code**: QRious.js
- **Notifications**: SweetAlert2
- **Data Tables**: DataTables

## 📋 Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau MariaDB 10.2
- Web server (Apache/Nginx)
- mod_rewrite enabled (untuk Apache)

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd urlshortener
```

### 2. Setup Database
- Buat database baru di MySQL/MariaDB
- Import file `db_url_shortener.sql`
- Atau jalankan query SQL yang ada di file tersebut

### 3. Konfigurasi Database
Edit file `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'db_url_shortener',
    // ... konfigurasi lainnya
);
```

### 4. Konfigurasi Base URL
Edit file `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/urlshortener/';
```

### 5. Setup .htaccess
Pastikan file `.htaccess` sudah ada di root folder dan mod_rewrite sudah enabled.

### 6. Set Permissions
```bash
chmod 755 application/cache/
chmod 755 application/logs/
```

## 👤 Login Admin

**Default Credentials:**
- Username: `admin`
- Password: `password`

**Untuk mengubah password:**
1. Login ke dashboard admin
2. Atau update langsung di database dengan hash bcrypt

## 📁 Struktur Database

### Tabel `urls`
- `id` - Primary key
- `original_url` - URL asli
- `short_code` - Kode singkat (unique)
- `custom_url` - Custom URL (opsional)
- `title` - Judul URL (opsional)
- `description` - Deskripsi URL (opsional)
- `clicks` - Jumlah klik
- `is_active` - Status aktif (1/0)
- `expired_at` - Tanggal kadaluarsa
- `created_at` - Tanggal dibuat
- `updated_at` - Tanggal update
- `ip_address` - IP pembuat
- `user_agent` - User agent pembuat

### Tabel `click_logs`
- `id` - Primary key
- `url_id` - Foreign key ke urls
- `ip_address` - IP pengunjung
- `user_agent` - User agent pengunjung
- `referer` - Referer URL
- `country` - Negara (untuk fitur geo)
- `city` - Kota (untuk fitur geo)
- `clicked_at` - Waktu klik

### Tabel `admin`
- `id` - Primary key
- `username` - Username admin
- `password` - Password hash (bcrypt)
- `email` - Email admin
- `created_at` - Tanggal dibuat

## 🔧 Konfigurasi Tambahan

### Mengubah Default Expired Time
Edit file `application/controllers/Url.php` pada method `shorten()`:
```php
// expired otomatis 30 hari jika kosong
if (empty($expired_at)) {
    $expired_at = date('Y-m-d H:i:s', strtotime('+30 days'));
}
```

### Mengubah Panjang Short Code
Edit file `application/controllers/Url.php`:
```php
$short_code = $custom_url ?: substr(md5(uniqid()), 0, 6); // Ubah angka 6
```

### Menambahkan Validasi URL
Edit file `application/controllers/Url.php` pada method `shorten()`:
```php
// Tambahkan validasi URL
if (!filter_var($original_url, FILTER_VALIDATE_URL)) {
    echo json_encode(['status' => 'error', 'message' => 'URL tidak valid!']);
    return;
}
```

## 🎨 Customisasi UI

### Mengubah Warna Tema
Edit file CSS di view files atau buat file CSS terpisah:
```css
:root {
    --primary-color: #4f46e5;    /* Warna utama */
    --primary-hover: #3730a3;    /* Warna hover */
    --success-color: #10b981;    /* Warna sukses */
    --danger-color: #ef4444;     /* Warna danger */
    --warning-color: #f59e0b;    /* Warna warning */
}
```

### Mengubah Background
Edit CSS di view files:
```css
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

## 🔒 Keamanan

### Fitur Keamanan yang Sudah Diterapkan
- ✅ Password hashing dengan bcrypt
- ✅ Session management
- ✅ CSRF protection (CodeIgniter built-in)
- ✅ SQL injection protection (CodeIgniter built-in)
- ✅ XSS protection (CodeIgniter built-in)
- ✅ Input validation dan sanitization

### Rekomendasi Keamanan Tambahan
1. **HTTPS**: Gunakan SSL certificate untuk production
2. **Rate Limiting**: Tambahkan rate limiting untuk API
3. **Captcha**: Tambahkan captcha untuk form
4. **Logging**: Aktifkan logging untuk monitoring
5. **Backup**: Lakukan backup database secara berkala

## 📊 Analytics

### Data yang Tersimpan
- Jumlah klik per URL
- IP address pengunjung
- User agent pengunjung
- Referer URL
- Waktu klik

### Fitur Analytics yang Tersedia
- Dashboard dengan statistik total
- Tabel dengan detail setiap URL
- Filter dan pencarian
- Export data (bisa ditambahkan)

## 🚀 Deployment

### Production Checklist
- [ ] Set `ENVIRONMENT = 'production'` di `index.php`
- [ ] Disable error reporting
- [ ] Setup HTTPS
- [ ] Konfigurasi caching
- [ ] Setup backup database
- [ ] Monitoring dan logging
- [ ] Rate limiting
- [ ] Security headers

### Performance Optimization
- [ ] Enable CodeIgniter caching
- [ ] Optimize database queries
- [ ] Minify CSS/JS
- [ ] Enable Gzip compression
- [ ] Use CDN for static assets

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.

## 🔄 Changelog

### v1.0.0
- ✅ Fitur dasar URL shortening
- ✅ Dashboard admin
- ✅ Edit dan hapus URL
- ✅ QR Code generator
- ✅ Analytics dasar
- ✅ UI/UX modern dan responsif
- ✅ Multi-language support (Indonesia) 