USE gymsystem;

-- ============================================================
-- SEEDER — Gymku
-- Password semua user: password123
-- ============================================================

-- 1. Users
INSERT INTO users (name, email, gender, password, role) VALUES
('Admin Gymku',   'admin@gymku.com',  'Laki-Laki', '$2y$10$PMqkzslekXi/7phPUwp5i.xXxBTPSz8905xytCgyrw6CVCzMCtoqa', 'Admin'),
('Pak Jokowi', 'priasolo@gmail.com',  'Laki-Laki', '$2y$10$PMqkzslekXi/7phPUwp5i.xXxBTPSz8905xytCgyrw6CVCzMCtoqa', 'Member'),
('Sari Dewi',     'sari@gmail.com',   'Wanita',    '$2y$10$PMqkzslekXi/7phPUwp5i.xXxBTPSz8905xytCgyrw6CVCzMCtoqa', 'Member'),
('Budi Santoso',  'budi@gmail.com',   'Laki-Laki', '$2y$10$PMqkzslekXi/7phPUwp5i.xXxBTPSz8905xytCgyrw6CVCzMCtoqa', 'Member');

-- 2. Packages
INSERT INTO packages (name, price, day_duration, status) VALUES
('Paket Basic',    150000, 30, 'Aktif'),
('Paket Standard', 300000, 60, 'Aktif'),
('Paket Premium',  500000, 90, 'Aktif');

-- 3. Registration
-- Pak Jokowi: aktif sudah bayar lunas
INSERT INTO registration (id_user, id_package, registration_date, start_date, expiry_date, status)
VALUES (2, 2, NOW(), '2026-03-01', '2026-05-01', 'active');

-- Sari: pending belum bayar
INSERT INTO registration (id_user, id_package, registration_date, start_date, expiry_date, status)
VALUES (3, 1, NOW(), '2026-03-03', '2026-04-03', 'pending');

-- Budi: tidak daftar sama sekali

-- 4. Payments
-- Pak Jokowi: Lunas
INSERT INTO payments (id_registration, payment_method, payment_status, payment_date, amount)
VALUES (1, 'Transfer Bank', 'Lunas', NOW(), 300000);

-- Sari: Belum Lunas
INSERT INTO payments (id_registration, payment_method, payment_status, payment_date, amount)
VALUES (2, 'QRIS', 'Belum Lunas', NOW(), 150000);