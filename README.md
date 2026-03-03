# 🏋️‍♂️ Gym Management System (Native PHP)

Sistem manajemen gym berbasis PHP Native — kelola member, paket, absensi, dan keuangan dalam satu platform.

---

## 🚀 Setup Lokal

### 1. Clone Repository

```bash
# Letakkan di dalam folder web server (Laragon/XAMPP)
cd C:/laragon/www/
git clone https://github.com/WahyuPratama222/PemWeb2-Half.git
```

> **Penting:** Nama folder boleh apa saja, URL akan otomatis menyesuaikan.

### 2. Setup Database

1. Buka **phpMyAdmin** atau **HeidiSQL**
2. Import file **`db.sql`** → nama database: `gymsystem`

### 3. Setup Environment

```bash
# Copy file template .env
cp .env.example .env
```

Lalu buka `.env` dan isi sesuai pengaturan lokalmu:

```env
DB_HOST=localhost
DB_NAME=gymsystem
DB_USER=root
DB_PASS=          ← isi password DB-mu di sini
APP_ENV=development
```

> **Catatan:** `BASE_URL` tidak perlu diisi — sudah terdeteksi otomatis.

### 4. Import Database

```bash
   copy db.sql lalu masukkan ke mysql
   copy seeder.sql lalu masukkan ke mysql
```

Admin:
admin@gymku.com

Member:
priasolo@gmail.com
sari@gmail.com
budi@gmail.com

Password:
Password123

### 5. Jalankan

Akses di browser: `http://localhost/nama-folder-kamu/`
