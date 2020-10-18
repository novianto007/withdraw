## Simple Withdraw App

Aplikasi ini dibuat menggunakan Framework Laravel versi 7.28, versi Php 7.2 dan database MariaDB versi 10.1

## Cara Menajalankan
1. copy file .env.example dan rename menajadi .env. Kemudian isikan configurasi database pada file tersebut.
2. jalankan perintah `php artisan key:generate` pada terminal.
3. jalankan perintah `composer install` pada terminal.
4. lakukan migration dengan perintah `php artisan migrate`.
5. lakukan seed data user dengan perintah `php artisan db:seed`.
6. jalankan perintah `php artisan queue:work` untuk menjalankan worker.
7. jalankan perintah `php artisan serve` untuk menjalakan aplikasi.
8. silakan login pada app dengan email `customer@mail.com` dan password `customer2020`.
