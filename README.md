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
![Screenshot 2023-06-25 232402](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/5cc2b29e-3a78-4ccc-8fff-08e88f33da83)
![Screenshot 2023-06-25 233754](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/4af1ac72-776b-4a45-a14b-8cb5e21a06b7)

## Tampilan Login
![Screenshot 2023-06-25 234617](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/b835028b-7388-4450-8f44-d6fd3af85883)

## Tampilan Admin
![Screenshot 2023-07-03 154955](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/ac8361a6-63c7-4033-80f6-49a0e4b708ea)
![Screenshot 2023-07-03 155020](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/849a5b97-6089-4bf1-a962-f278e2dd8a30)
![Screenshot 2023-06-26 001236](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/a3fa7c9a-8e30-408b-a082-9f0d67951caa)

## Tampilan Petugas
![Screenshot 2023-07-03 155219](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/836eed75-6750-4064-85ec-45b1b4781fba)
![Screenshot 2023-07-03 155241](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/699e5768-3a8f-450e-86c0-21ad78cb552f)
![Screenshot 2023-07-03 155302](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/c7baecab-5c3a-4474-9445-4bee3d77ebbe)
![Screenshot 2023-06-18 215000](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/36a6739e-4afe-4c88-bbd8-8da3fd73252d)

## Tampilan Pemilih
![Screenshot 2023-06-26 001738](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/6326b94c-4a3a-4344-971d-ec5ec26c1e51)
![Screenshot 2023-06-26 001754](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/d56010f3-e32c-45ba-aa04-0efab8da0a7a)
![Screenshot 2023-06-26 001830](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/8deef5fc-48e6-4a52-b8bd-7edf870c1f35)
![Screenshot 2023-06-26 001845](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/d963bd5f-82e1-4785-9de9-3090b4784de1)


## Tampilan Frontend dengan Consume API
![Screenshot 2023-07-03 155714](https://github.com/WayanDev/MSIB-group-task-Wayan/assets/113874200/cb561a03-87bd-45bd-81f6-508b8bdde7ff)


## Kredit
-   Sistem mulai dibuat pada 01/06/2023
