# WargaConnect
Aplikasi Manajemen Warga RT 35 / RW 08.

## Fitur Utama
- **Manajemen Warga**: Pendataan warga dan anggota keluarga (KK).
- **Pembayaran Iuran**: Pembayaran iuran bulanan (Keamanan, Kebersihan, dll) dengan status validasi.
- **Laporan Keuangan**: Transparansi dana masuk dan keluar (Coming Soon).
- **Pengumuman**: Informasi penting dari pengurus untuk warga.

## Instalasi
1. Clone repository.
2. `composer install`
3. `npm install && npm run build`
4. `cp .env.example .env` (Konfigurasi DB)
5. `php artisan key:generate`
6. `php artisan migrate:fresh --seed` (Default Admin: admin@simpleakunting.my.id / WargaConnect2025!)

## Tech Stack
- Laravel 11
- Tailwind CSS
- Alpine.js
- MySQL
