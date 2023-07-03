# Sistem E-Voting Kepala Desa (Studi Independen PT Hendevane Indonesia)

<img alt="HTML5" src="https://img.shields.io/badge/html5%20-%23E34F26.svg?&style=for-the-badge&logo=html5&logoColor=white"><img alt="CSS3" src="https://img.shields.io/badge/css3%20-%231572B6.svg?&style=for-the-badge&logo=css3&logoColor=white"><img alt="PHP" src="https://img.shields.io/badge/php-%23777BB4.svg?&style=for-the-badge&logo=php&logoColor=white"><img alt="Bootstrap" src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white"><img alt="Bootstrap" src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">

## Deskripsi

Sistem ini dibuat untuk memenuhi Tugas Akhir kegiatan MSIB di PT Handevane Indonesia. Dalam sebuah kecamatan akan melaksanakan pemilihan kepala desa di beberapa desa secara serentak dan akan dilaksanakan dengan menggunakan sistem e-voting. Admin merupakan operator kecamatan, Petugas desa merupakan operator desa dan Pemilih merupakan penduduk desa.

Sistem ini dibangun menggunakan **CSS (Cascading Style Sheet)**,**HTML (Hypertext Markup Language)**,**Laravel 10**,**Bootstrap(Admin LTE)** dan **PHP (Hypertext Preprocessor)**.

## Fitur

Fitur yang ada pada Sistem E-Voting Kepala Desa:

1. Tambah data list pemilih
2. Tambah data akun pemilih
3. Tambah data kandidat
4. Tambah data list desa
5. Tambah data akun desa
6. Login/Logout
7. Autorisasi dan Autentikasi
8. Dashboard

## ERD
![DATABASE](https://github.com/abduromanov2020/MSIB-group-task/assets/113874200/d7a876a4-73cd-4507-9b0c-08cbfe04c3d9)



## Langkah-Langkah

1. Download Source Code dari repo Github (https://github.com/WayanDev/MSIB-group-task-Wayan.git) dalam bentuk Zip.
2. Extract file zip (source code) ke dalam direktori htdocs pada XAMPP, misal htdocs/Pilkades. Tanpa di htdocs pun bisa, bisa juga di folder D.
3. Melalui terminal, arahkan ke folder project cth: cd C:\xampp\htdocs\Pilkades.
4. (Sesuai petunjuk installasi) Pada terminal, jalankan perintah ```composer install```. Pastikan PC/Laptop terkoneksi internet.
5. Pastikan juga Anda sudah mengintall composer
6. Composer akan menginstall dependency paket dari source code tersebut hingga selesai.
7. Buat database baru pada mysql (via phpmyadmin) dengan nama laravel atau bebas. Import file laravel.sql(ada di Folder Desain Database) ke database yang sudah dibuat tadi.
8. Duplikat file .env.example, lalu rename menjadi .env.
9. Kembali ke terminal, jalankan perintah ```php artisan key:generate```.
10. Setting koneksi database di file .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
 ```
     DB_CONNECTION=mysql 
     DB_HOST=127.0.0.1 
     DB_PORT=3306 
     DB_DATABASE=laravel 
     DB_USERNAME=root 
     DB_PASSWORD= 
 ```
11. Setelah selesai, Jalankan perintah ```php artisan serve``` maka dapat diakses dengan (http://127.0.0.1:8000)

## Persyaratan

-   XAMPP : PHP >= minimal 8.1
-   Google Chrome atau web browser lainnya
-   Composer telah ter-install, cek dengan perintah composer -V melalui terminal.
-   Koneksi Internet

## Catatan

Login admin

> Username : admin
> 
> Password : 12345678

## Tampilan Home 
![Screenshot 2023-06-25 232402](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/2b557741-f937-4db8-9a2f-21a2ccc7b9a2)
![Screenshot 2023-06-25 233754](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/9b2cf203-d66c-4f13-90c1-6daa9f641cab)

## Tampilan Login
![Screenshot 2023-06-25 234617](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/543223de-4d34-4389-9f42-774151eca299)

## Tampilan Admin
![Screenshot 2023-07-03 154955](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/ca701798-f562-4302-b83e-8b11d69f1cd1)
![Screenshot 2023-07-03 155020](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/cfd1745d-afa3-4085-9049-01c19f1b6be8)

## Tampilan Petugas
![Screenshot 2023-07-03 155219](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/e723acda-cfe4-4698-899f-ed41d12d1c94)
![Screenshot 2023-07-03 155241](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/8f8d72e8-621e-4510-87be-f75b4dbd1f7f)
![Screenshot 2023-07-03 155302](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/4ac11b96-f0c9-4246-a27c-8bf6cf13fdee)


## Tampilan Pemilih
![Screenshot 2023-06-18 001828](https://github.com/abduromanov2020/MSIB-group-task/assets/113874200/cd84920b-b14e-4f38-ae3c-d19ba1974c3b)
![Screenshot 2023-06-18 001813](https://github.com/abduromanov2020/MSIB-group-task/assets/113874200/8cf07304-db58-4756-a8c0-d02356919307)



## Kredit
-   Sistem mulai dibuat pada 01/06/2023
