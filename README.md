# 🏋️‍♂️ Gym Management System (Native PHP)

Sistem manajemen gym berbasis PHP Native — kelola member, paket, absensi, dan keuangan dalam satu platform.

---

## 🚀 Setup Lokal (WAJIB DIBACA)

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

### 4. Jalankan

Akses di browser: `http://localhost/nama-folder-kamu/`

---

## 🌿 Aturan Branching (Penting!)

**Jangan pernah commit langsung ke branch `main`.**

```bash
# 1. Buat branch dengan namamu
git checkout -b nama-kamu

# 2. Coding & commit di branch-mu
git add .
git commit -m "feat: deskripsi singkat perubahan"

# 3. Push ke GitHub
git push origin nama-kamu
```

Setelah selesai, buat **Pull Request** di GitHub untuk di-review sebelum merge ke `main`.

---

## 📁 Struktur Folder

| Folder      | Fungsi                                           |
| ----------- | ------------------------------------------------ |
| `admin/`    | Halaman & fitur khusus Administrator             |
| `member/`   | Halaman & fitur khusus Member                    |
| `auth/`     | Login, Logout, Register                          |
| `actions/`  | Proses POST (insert, update, delete)             |
| `models/`   | Query database per entitas                       |
| `config/`   | Konfigurasi koneksi database                     |
| `core/`     | Bootstrap aplikasi (`init.php`, `functions.php`) |
| `includes/` | Komponen UI global (`header.php`, `footer.php`)  |
| `assets/`   | CSS, JS, dan gambar statis                       |

---

## 🛠️ Aturan Koding

1. **Setiap file PHP** wajib diawali dengan:
   ```php
   require_once __DIR__ . '/../core/init.php'; // sesuaikan kedalaman path
   ```
2. Gunakan **`$pdo`** untuk semua query database (PDO + prepared statements).
3. Gunakan **`escape()`** untuk output ke HTML, **bukan** `echo $var` langsung.
4. URL diakses **tanpa `.php`** — sudah dihandle `.htaccess`.
5. Ikuti format kode sesuai **`.editorconfig`** (indent 4 spasi, UTF-8).

---

## ⚙️ Variabel Environment (`.env`)

| Variable  | Keterangan                                                        |
| --------- | ----------------------------------------------------------------- |
| `DB_HOST` | Host database (default: `localhost`)                              |
| `DB_NAME` | Nama database                                                     |
| `DB_USER` | Username database                                                 |
| `DB_PASS` | Password database                                                 |
| `APP_ENV` | `development` (error tampil) / `production` (error disembunyikan) |
