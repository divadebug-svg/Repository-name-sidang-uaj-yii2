# SIDANG UAJ - Yii Framework 2

Sistem Penilaian Sidang Skripsi Universitas Al Hikmah Jepara.

## Persyaratan

- XAMPP dengan PHP 8.2 atau lebih baru
- MySQL/MariaDB
- Composer terbaru

Yii 2 terbaru membutuhkan PHP minimal 7.4, sedangkan konfigurasi proyek ini memakai PHP >= 8.2 agar selaras dengan template Yii 2 Basic saat ini.

## Instalasi di Windows/XAMPP

1. Extract folder `sidang-uaj-yii2` ke `C:\xampp\htdocs\`.
2. Buat database MySQL bernama `sidang_uaj`.
3. Pastikan `config/db.php` berisi:

```php
'dsn' => 'mysql:host=127.0.0.1;dbname=sidang_uaj',
'username' => 'root',
'password' => '',
```

4. Buka CMD dan masuk ke folder proyek:

```bat
cd C:\xampp\htdocs\sidang-uaj-yii2
```

5. Jika sebelumnya Composer gagal, hapus `vendor` dan `composer.lock` yang lama (jika ada), lalu jalankan:

```bat
composer clear-cache
composer update --prefer-dist
```

atau pada instalasi baru:

```bat
composer install
```

`composer.json` proyek sudah menyediakan repository `asset-packagist.org` karena Yii 2 membutuhkan beberapa paket Bower asset seperti jQuery, inputmask, punycode, dan yii2-pjax.

6. Jalankan migration:

```bat
php yii migrate --interactive=0
```

7. Jalankan aplikasi:

```bat
php yii serve --port=8080
```

Buka:

http://localhost:8080/

## Jika menggunakan Apache XAMPP

Arahkan DocumentRoot/VirtualHost ke folder:

```text
C:\xampp\htdocs\sidang-uaj-yii2\web
```

Kemudian akses alamat VirtualHost yang Anda buat.

## Fitur

- Dashboard statistik mahasiswa, dosen penguji, dan sidang dinilai
- CRUD mahasiswa
- CRUD dosen penguji
- CRUD kriteria dan bobot
- Input nilai setiap kriteria
- Perhitungan nilai akhir berbobot
- Konversi nilai huruf A/B/C/D
- Rekap nilai rata-rata berdasarkan mahasiswa
- Export CSV
- MySQL + Yii ActiveRecord
- Yii Migration

## Catatan penting

Aplikasi HTML awal menyimpan data menggunakan `localStorage`. Versi Yii ini memindahkan penyimpanan ke MySQL sehingga data tidak lagi hanya tersimpan di browser.
