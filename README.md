# 📖 QuranQita API

API QuranQita menyediakan data Al-Qur'an lengkap beserta terjemahan dan tafsir.

## ✨ Fitur

-   Daftar surah
-   Detail surah
-   Detail ayat
-   Terjemahan
-   Tafsir

## 📦 Instalasi

1. Clone repository:
    ```bash
    git clone https://github.com/username/quranqita-api.git
    ```
2. Masuk ke folder proyek:
    ```bash
    cd quranqita-api
    ```
3. Install dependencies:
    ```bash
    composer install
    ```
4. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi.
5. Generate application key:
    ```bash
    php artisan key:generate
    ```
6. Jalankan migrasi database:
    ```bash
    php artisan migrate --seed
    ```
7. Jalankan server:
    ```bash
    php artisan serve
    ```
