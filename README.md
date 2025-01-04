# Aplikasi Laravel dengan Breeze dan Midtrans

## Deskripsi
Aplikasi ini dibangun menggunakan Laravel framework dengan implementasi authentication menggunakan Laravel Breeze dan integrasi pembayaran menggunakan Midtrans.

## Persyaratan Sistem
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Git
- Akun Midtrans

## Instalasi

1. Clone repositori
```bash
git clone https://github.com/fahrezapratamahidayat/donasi-laravel-10.git
cd donasi-laravel-10
```
2. Install composer
```bash
composer install
```
3. Install npm
```bash
npm install
```
4. copy .env.example
```bash
cp .env.example .env
```
5. generate key
```bash
php artisan key:generate
```
6. konfigurasi database
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_breeze
DB_USERNAME=root
DB_PASSWORD=
```
7. konfigurasi midtrans
```bash
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```
8. migrate database
```bash
php artisan migrate
```
9. run server
```bash
php artisan serve
```


## Fitur
- Autentikasi pengguna (Login, Register, Reset Password)
- Dashboard admin
- Integrasi pembayaran Midtrans
- Manajemen transaksi
- Riwayat pembayaran

## Konfigurasi Midtrans

1. Daftar akun di [Midtrans](https://midtrans.com/)
2. Dapatkan Server Key dan Client Key dari dashboard Midtrans
3. Masukkan key tersebut ke file .env
4. Pastikan mengatur MIDTRANS_IS_PRODUCTION=false untuk testing

## Penggunaan

1. Register akun baru atau login dengan akun yang sudah ada
2. Akses dashboard untuk melihat menu yang tersedia
3. Untuk melakukan pembayaran:
   - Pilih produk/layanan
   - Klik tombol bayar
   - Ikuti instruksi pembayaran dari Midtrans
   - Cek status pembayaran di halaman riwayat transaksi

## Troubleshooting

1. Jika terjadi error saat instalasi:
    - Pastikan PHP, Composer, Node.js, dan MySQL/PostgreSQL sudah terinstall
    - Pastikan file .env sudah diatur dengan benar
    - Pastikan database sudah dikonfigurasi dan terhubung
    - Pastikan akun Midtrans sudah terdaftar dan key sudah diisi

2. Jika terjadi error saat penggunaan:
    - Pastikan akun Midtrans sudah terdaftar dan key sudah diisi
    - Pastikan pengaturan MIDTRANS_IS_PRODUCTION=false untuk testing
    - Pastikan pengaturan MIDTRANS_IS_SANITIZED=true dan MIDTRANS_IS_3DS=true untuk keamanan
    - Pastikan pengaturan MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY sudah diisi
    - Pastikan pengaturan MIDTRANS_IS_PRODUCTION=false untuk testing
    - Pastikan pengaturan MIDTRANS_IS_SANITIZED=true dan MIDTRANS_IS_3DS=true untuk keamanan
