# Aplikasi Web Sistem Monitoring Karyawan/Pegawai Laravel 11

![Aplikasi Web Sistem Monitoring Pegawai](./Screenshot/hero.png)

Aplikasi web sistem monitoring pegawai sebagai absensi dan monitoring tugas.

## Sistem dan Alat Yang Terapkan

-   [Laravel 11](https://laravel.com/)
-   [Simple QR Code](https://github.com/SimpleSoftwareIO/simple-qrcode)
-   [html5 Qr Code Scanner](https://github.com/mebjas/html5-qrcode)
-   [Stisla Bootsrap Template](https://github.com/stisla/stisla)
-   MySQL/MariaDB

## Instalasi

### Persyaratan

-   [Composer](https://getcomposer.org)
-   [imagick](https://github.com/Imagick/imagick)
-   PHP 8.2 atau Diatasnya
-   MySQL/MariaDB

---

1. Clone/download repository ini
2. Jalankan perintah `composer run-script post-root-package-install` untuk membuat file `.env`
3. Jalankan perintah `composer install` untuk menginstalasi dependency
4. Jalankan perintah `php artisan key:generate --ansi --force` untuk membuat key aplikasi
5. Jalankan perintah `php artisan migrate` untuk membuat tabel database
6. Jalankan perintah `php artisan serve` untuk menjalankan aplikasi

### Seeder

Gunakan perintah di bawah untuk menyiapkan data dummy awal.

-   `php artisan db:seed DatabaseSeeder`

## Fitur & Pratinjau

### User/Pegawai Page

| Dashboard User/Pegawai                             |
| -------------------------------------------------- |
| ![Dashboard](./Screenshot/user/user-dashboard.png) |

| User/Pegawai Page - Absensi Masuk                         | User/Pegawai Page - Absensi Keluar                          |
| --------------------------------------------------------- | ----------------------------------------------------------- |
| ![Absensi Masuk](./Screenshot/user/user-absensimasuk.png) | ![Absensi Keluar](./Screenshot/user/user-absensikeluar.png) |

| User/Pegawai Page - Detail Absen                     |
| ---------------------------------------------------- |
| ![Dashboard](./Screenshot/user/user-detailabsen.png) |

| User/Pegawai Page - Tugas                         | User/Pegawai Page - Tugas Detail                         |
| ------------------------------------------------- | -------------------------------------------------------- |
| ![Absensi Masuk](./Screenshot/user/user-task.png) | ![Absensi Keluar](./Screenshot/user/user-taskdetail.png) |

### Admin & Manager Page

| Dashboard Admin                                |
| ---------------------------------------------- |
| ![Dashboard](./Screenshot/Admin-Dashboard.png) |

| Barcode                              |
| ------------------------------------ |
| ![Barcode](./Screenshot/Barcode.png) |

| Rekap Data                                       |
| ------------------------------------------------ |
| ![Rekap Data](./Screenshot/Admin-Rekap-Data.png) |

| Admin/Manager Page - Absensi Masuk               | Admin/Manager Page - Absensi Keluar                |
| ------------------------------------------------ | -------------------------------------------------- |
| ![Absensi Masuk](./Screenshot/Absensi-Masuk.png) | ![Absensi Keluar](./Screenshot/Absensi-Keluar.png) |

| List Data Absensi Pegawai/Karyawan                          |                                                               |                                                           |
| ----------------------------------------------------------- | ------------------------------------------------------------- | --------------------------------------------------------- |
| Absensi Hari Ini                                            | Absensi Mingguan                                              | Absensi Bulanan                                           |
| ![Absensi Hari Ini](./Screenshot/List-Absensi-Hari-Ini.png) | ![Absensi per minggu](./Screenshot/List-Absensi-Mingguan.png) | ![Absensi Bulanan](./Screenshot/List-Absensi-Bulanan.png) |

| Data Pegawai/Karyawan                                         | Create/Edit Data Karyawan                                         |
| ------------------------------------------------------------- | ----------------------------------------------------------------- |
| ![Data Pegawai/Karyawan](./Screenshot/Data-Pegawai-Table.png) | ![Create Edit Data Karyawan](./Screenshot/Data-Pegawai-Input.png) |

| Data Bagian                                  | Data Jabatan                                   | Data Shift                                 |
| -------------------------------------------- | ---------------------------------------------- | ------------------------------------------ |
| ![Data Bagian](./Screenshot/Data-Bagian.png) | ![Data Jabatan](./Screenshot/Data-Jabatan.png) | ![Data Shift](./Screenshot/Data-Shift.png) |

| List Data SOP                          | Create/Edit Data SOP                                     |
| -------------------------------------- | -------------------------------------------------------- |
| ![Data SOP](./Screenshot/List-SOP.png) | ![Create Edit Data SOP](./Screenshot/List-SOP-Input.png) |

| List Data Tugas                          | Create/Edit Tugas Dan Memberikan Tugas Kepada Pegawai/Karyawan |
| ---------------------------------------- | -------------------------------------------------------------- |
| ![Data SOP](./Screenshot/List-Tugas.png) | ![Create Edit Data SOP](./Screenshot/List-Tugas-Input.png)     |

| Manage User                                    |
| ---------------------------------------------- |
| ![Manage USer](./Screenshot/Manage%20User.png) |

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
