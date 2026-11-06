# Aplikasi Pendaftaran Aula Kantor — Laravel

Aplikasi ini menyediakan:
- Login/logout pengguna dan admin
- 2 aula bawaan: Aula Besar (100 orang) dan Aula Kecil (30 orang)
- Pendaftaran aula berdasarkan tanggal dan jam
- Validasi kapasitas peserta
- Validasi bentrok jadwal
- Dashboard pengguna
- Dashboard admin
- Admin dapat menyetujui/menolak pendaftaran
- Admin dapat mengelola data aula
- Riwayat pendaftaran
- Tampilan responsif dengan tema pink

## Cara menjalankan

1. Buat project Laravel baru:
   ```bash
   composer create-project laravel/laravel aplikasi-aula
   ```
   Atau gunakan project Laravel yang sudah kamu punya.

2. Salin isi folder `app`, `database`, `resources`, dan `routes` dari paket ini ke project Laravel kamu.

3. Atur `.env` untuk database MySQL:
   ```env
   DB_DATABASE=aula_kantor
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Buat database `aula_kantor` di phpMyAdmin.

5. Jalankan:
   ```bash
   php artisan migrate:fresh --seed
   ```

6. Jalankan server:
   ```bash
   php artisan serve
   ```

7. Buka:
   `http://127.0.0.1:8000`

## Akun demo

Admin:
- Email: admin@aula.test
- Password: password

User:
- Email: user@aula.test
- Password: password

## Catatan

Kode dibuat tanpa Laravel Breeze/Jetstream agar mudah dipahami dan langsung bisa digunakan pada project Laravel baru.
