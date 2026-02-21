# 🏋️‍♂️ Gym Management System (Native PHP)

Repositori ini adalah sistem manajemen gym yang dibangun menggunakan PHP Native. 

---

## 🚀 Cara Setup & Kolaborasi (WAJIB DIBACA)

Ikuti langkah ini agar folder proyek kita sinkron dan tidak berantakan:

### 1. Inisialisasi Proyek
1.  Buat folder baru di dalam `C:/laragon/www/` atau `C:/xampp/htdocs/`.
2.  Masuk ke dalam folder tersebut melalui Terminal/CMD.
3.  Pastikan Git sudah terinstall, lalu jalankan perintah:
    ```bash
    git init
    ```
4.  Hubungkan dengan repositori pusat:
    ```bash
    git remote add origin [https://github.com/WahyuPratama222/PemWeb2-Half.git](https://github.com/WahyuPratama222/PemWeb2-Half.git)
    ```
5.  Ambil data dari branch utama:
    ```bash
    git pull origin main
    ```

### 2. Aturan Branching (Penting!)
**Jangan pernah melakukan commit langsung di branch `main`**. Ikuti alur ini:
1.  Buat branch baru sesuai namamu:
    ```bash
    git checkout -b nama-kamu
    ```
    *(Contoh: `git checkout -b wahyu`)*
2.  Lakukan coding dan commit di branch tersebut.
3.  Jika ingin upload ke GitHub:
    ```bash
    git push origin nama-kamu
    ```

### 3. Konfigurasi Environment & DB
1.  Import file **`db.sql`** ke phpMyAdmin (Nama DB: `gymsystem`).
2.  Cari file **`.env.example`**, lalu **Rename** menjadi **`.env`**.
3.  Buka file `.env` dan isi password database masing-masing (Isi `DB_PASS` sesuai settingan Laragon/XAMPP-mu).

---

## 📁 Struktur Folder
* **`admin/`** : Fitur khusus Administrator.
* **`member/`** : Fitur khusus Member.
* **`auth/`** : Proses Login & Logout.
* **`actions/`** : Pusat logika/query PHP (Insert, Update, Delete).
* **`config/`** : Pengaturan database.
* **`core/`** : Otak aplikasi (`init.php`).
* **`includes/`** : Potongan UI (Header, Footer).
* **`assets/`** : CSS, JS, dan Gambar.

---

## 🛠 Aturan Koding
1.  Wajib panggil `require_once '../core/init.php';` di setiap baris pertama file PHP baru.
2.  Gunakan variabel `$pdo` untuk urusan database.
3.  Akses file tanpa `.php` di URL (Contoh: `auth/login`).

---