-- 1. Buat Database
CREATE DATABASE gymsystem;
USE gymsystem;

-- 2. Tabel Users
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    gender ENUM('Laki-Laki', 'Wanita'),
    password VARCHAR(255),git commit -m "kirim database dan folder project"
    role ENUM('Member', 'Admin') DEFAULT 'Member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. Tabel Packages
CREATE TABLE packages (
    id_package INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(100) DEFAULT 'default.jpg',
    price DECIMAL(12, 0) NOT NULL,
    day_duration INT NOT NULL,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 4. Tabel Pendaftaran
CREATE TABLE registration (
    id_registration INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_package INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    start_date DATE NOT NULL,
    expiry_date DATE NOT NULL,
    status ENUM('active', 'expired', 'pending', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_package) REFERENCES packages(id_package)
);

-- 5. Tabel Pembayaran
CREATE TABLE payments (
    id_payment INT AUTO_INCREMENT PRIMARY KEY,
    id_registration INT NOT NULL,
    -- Menambah opsi E-Wallet/QRIS yang populer di Gym
    payment_method ENUM('Transfer Bank', 'Tunai', 'QRIS', 'E-Wallet') NOT NULL,
    payment_status ENUM('Lunas', 'Belum Lunas', 'Gagal') DEFAULT 'Belum Lunas',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    amount DECIMAL(12, 0) NOT NULL,
    FOREIGN KEY (id_registration) REFERENCES registration(id_registration) ON DELETE CASCADE
);

-- 6. Tabel Progress (
    CREATE TABLE progress (
    id_progress INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    record_date DATE NOT NULL,

    weight DECIMAL(5,2) NULL,        -- Berat badan (kg)
    height DECIMAL(5,2) NULL,        -- Tinggi badan (cm)
    body_fat DECIMAL(5,2) NULL,      -- Body fat (%)
    muscle_mass DECIMAL(5,2) NULL,   -- Massa otot (kg)
    chest DECIMAL(5,2) NULL,         -- Lingkar dada (cm)
    waist DECIMAL(5,2) NULL,         -- Lingkar perut (cm)
    biceps DECIMAL(5,2) NULL,        -- Lingkar lengan (cm)
    thigh DECIMAL(5,2) NULL,         -- Lingkar paha (cm)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

-- 7. Tabel Attendance
CREATE TABLE attendance (
    id_attendance INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    check_in TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    check_out TIMESTAMP NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

-- 8. Tabel Dashboard
CREATE OR REPLACE VIEW dashboard_summary AS
SELECT
    (SELECT COUNT(*) FROM users WHERE role='Member' AND is_active=1) AS total_members,
    (SELECT COUNT(*) FROM packages WHERE status='Aktif') AS active_packages,
    (SELECT COUNT(*) FROM registration WHERE status='active') AS active_memberships,
    (SELECT COUNT(*) FROM registration WHERE status='expired') AS expired_memberships,
    (SELECT COALESCE(SUM(amount),0) FROM payments WHERE payment_status='paid'
        AND DATE(paid_at) = CURDATE()) AS income_today,
    (SELECT COALESCE(SUM(amount),0) FROM payments WHERE payment_status='paid'
        AND YEAR(paid_at)=YEAR(CURDATE()) AND MONTH(paid_at)=MONTH(CURDATE())) AS income_this_month,
    (SELECT COUNT(*) FROM attendance WHERE DATE(check_in)=CURDATE()) AS checkins_today;






