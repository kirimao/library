# Panduan Hosting Aplikasi Perpustakaan YPA di Microsoft Azure

Dokumen ini berisi panduan langkah demi langkah untuk melakukan *deployment* / hosting aplikasi **Perpustakaan YPA** (Laravel 11 + Livewire 3 + Vite + MySQL) di platform **Microsoft Azure**.

---

## 🏗️ Komponen Azure yang Dibutuhkan

Untuk menjalankan aplikasi Laravel secara optimal di Azure, kita akan menggunakan 2 layanan utama:
1. **Azure App Service (Linux - PHP 8.2/8.3)**: Sebagai *Web Host* tempat aplikasi Laravel dan Vite assets berjalan.
2. **Azure Database for MySQL (Flexible Server)**: Sebagai basis data produksi MySQL.

---

## 📋 LANGKAH 1: Persiapan Database MySQL di Azure

1. Buka [Azure Portal](https://portal.azure.com/) dan masuk ke akun Azure Anda.
2. Cari dan pilih **Azure Database for MySQL flexible servers** > klik **Create**.
3. Isi konfigurasi database:
   - **Resource Group**: Buat baru, contoh `rg-perpustakaan-ypa`
   - **Server Name**: Contoh `db-ypa-library`
   - **Workload Type**: Pilih `Development` atau `Production` (sesuai anggaran)
   - **Admin Username**: Contoh `ypaadmin`
   - **Password**: Buat kata sandi yang kuat
4. Di tab **Networking**:
   - Centang *"Allow public access from any Azure service within Azure to this server"*.
5. Klik **Review + create** > **Create**.
6. Setelah server dibuat, buka resource database tersebut > pilih **Databases** > klik **+ Add** untuk membuat database bernama `library_db`.

---

## 🌐 LANGKAH 2: Membuat Azure App Service (Web App)

1. Di Azure Portal, pilih **App Services** > klik **Create** > **Web App**.
2. Isi formulir pembuatan:
   - **Resource Group**: Pilih `rg-perpustakaan-ypa`
   - **Name**: Contoh `ypa-library` (URL menjadi `https://ypa-library.azurewebsites.net`)
   - **Publish**: `Code`
   - **Runtime stack**: `PHP 8.2` atau `PHP 8.3`
   - **Operating System**: `Linux`
   - **Region**: Pilih lokasi terdekat (misal `Southeast Asia` / Singapura)
   - **Pricing Plan**: Pilih `Basic (B1)` atau `Free (F1)` untuk uji coba.
3. Klik **Review + create** > **Create**.

---

## ⚙️ LANGKAH 3: Konfigurasi Startup & Environment Variables di Azure App Service

Karena Laravel menyajikan websitenya dari folder `public/`, kita perlu memberitahu Web Server Nginx di Azure untuk mengarahkan dokumen root ke folder `public/`.

### A. Atur Startup Command (Dokumen Root Nginx)
1. Di Azure Portal, buka App Service Anda (`ypa-library`).
2. Di menu sebelah kiri, pilih **Configuration** > tab **General settings**.
3. Pada kolom **Startup Command**, masukkan perintah berikut:
   ```bash
   cp /home/site/wwwroot/default /etc/nginx/sites-available/default && sed -i 'pxroot /home/site/wwwroot/public;x' /etc/nginx/sites-available/default && service nginx reload
   ```
4. Klik **Save**.

### B. Konfigurasi Environment Variables (Application Settings)
1. Pilih tab **Application settings** di bawah menu **Configuration**.
2. Tambahkan variabel berikut (sesuai file `.env` produksi Anda):

| Name | Value / Contoh Value |
| :--- | :--- |
| `APP_NAME` | `Perpustakaan YPA` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | *(Salin dari file `.env` lokal Anda `base64:...`)* |
| `APP_URL` | `https://ypa-library.azurewebsites.net` |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `db-ypa-library.mysql.database.azure.com` |
| `DB_PORT` | `3306` |
| `DB_DATABASE` | `library_db` |
| `DB_USERNAME` | `ypaadmin` |
| `DB_PASSWORD` | *(Kata sandi MySQL Azure Anda)* |

3. Klik **Save**.

---

## 🚀 LANGKAH 4: Deployment Menggunakan GitHub Actions (Otomatis / CI-CD)

Metode terbaik untuk *deploy* aplikasi Laravel ke Azure adalah menggunakan **GitHub Actions**.

### 1. Upload Project ke Repository GitHub
Pastikan seluruh file project Anda (termasuk folder `public/images/`) sudah di-push ke repository GitHub.

### 2. Unduh Publish Profile dari Azure
1. Di Azure Portal pada halaman App Service Anda, klik tombol **Get publish profile** di bagian atas.
2. File `.PublishSettings` akan terunduh.
3. Buka repository project Anda di GitHub > **Settings** > **Secrets and variables** > **Actions** > **New repository secret**.
4. Beri nama secret: `AZURE_WEBAPP_PUBLISH_PROFILE` dan paste isi file `.PublishSettings` tadi.

### 3. Buat File Workflow GitHub Actions
Di dalam project Anda, buat file baru di `.github/workflows/deploy-azure.yml`:

```yaml
name: Deploy Laravel App to Azure App Service

on:
  push:
    branches: [ "main", "master" ]

jobs:
  build-and-deploy:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, pdo, pdo_mysql, ctype, tokenizer, xml, curl

    - name: Install Composer Dependencies
      run: composer install --no-dev --optimize-autoloader --no-interaction

    - name: Setup Node.js & Build Assets
      uses: actions/setup-node@v3
      with:
        node-version: '20'

    - name: Install NPM & Build Vite Assets
      run: |
        npm ci
        npm run build

    - name: Deploy to Azure Web App
      uses: azure/webapps-deploy@v2
      with:
        app-name: 'ypa-library'
        publish-profile: ${{ secrets.AZURE_WEBAPP_PUBLISH_PROFILE }}
        package: .
```

---

## 🛠️ LANGKAH 5: Inisialisasi Database & Storage Link di Azure

Setelah deployment pertama selesai, Anda cukup menjalankan perintah migrasi dan storage link via SSH Azure:

1. Buka Azure Portal > App Service `ypa-library`.
2. Di sidebar kiri, cari dan buka **SSH** (di bawah *Development Tools*) > klik **Go**.
3. Di dalam terminal SSH Azure, jalankan perintah berikut:
   ```bash
   cd /home/site/wwwroot

   # 1. Migrasi Database & Seeder
   php artisan migrate --force --seed

   # 2. Buat Symlink Storage untuk foto/cover
   php artisan storage:link

   # 3. Cache Konfigurasi & Route
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

 Selesai! Aplikasi Perpustakaan YPA kini dapat diakses secara publik via HTTPS di Azure.
