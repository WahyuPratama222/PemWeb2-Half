<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-color-2 fw-bold mb-0">Kelola Paket</h4>
            <small class="text-muted-dark">Kelola paket membership gym</small>
        </div>
        <button class="btn btn-color-2 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahPaket">>
            <i class="bi bi-plus-lg me-1"></i> Tambah Paket
        </button>
    </div>

    <?php show_flash(); ?>

    <!-- List Paket -->
    <?php if (empty($packages)): ?>
        <div class="alert alert-warning text-color-4">Belum ada paket tersedia.</div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($packages as $p): ?>
                <div class="col-sm-6 col-xl-4">
                    <div class="card bg-color-1 border border-secondary text-color-4 h-100">
                        <div class="card-body p-4 d-flex flex-column gap-3">

                            <!-- Header: Nama + Status -->
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold fs-6"><?= escape($p['name']) ?></div>
                                    <div class="small text-muted-dark"><?= escape($p['day_duration']) ?> Hari</div>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <?php if ((bool)$p['is_premium']): ?>
                                        <span class="badge bg-warning text-dark">Premium</span>
                                    <?php endif; ?>
                                    <?php if ($p['status'] === 'Aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-color-1">Nonaktif</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="text-color-2 fw-bold fs-5"><?= format_rupiah((float) $p['price']) ?></div>

                            <!-- Aksi -->
                            <div class="d-flex gap-2 mt-auto">
                                <a href="<?= BASE_URL ?>controllers/admin/packages_admin.php?edit=<?= $p['id_package'] ?>"
                                    class="btn btn-sm btn-outline-color-2 flex-grow-1">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <a href="<?= BASE_URL ?>actions/delete_package.php?id=<?= $p['id_package'] ?>"
                                    class="btn btn-sm btn-outline-color-3" onclick="return confirm('Hapus paket ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Modal Tambah Paket -->
    <div class="modal fade" id="modalTambahPaket" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-color-1 border border-secondary text-color-4">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold">Tambah Paket Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="<?= BASE_URL ?>actions/save_package.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-color-3 small">Nama Paket</label>
                            <input type="text" name="name" class="form-control bg-color-1 text-color-4 border-secondary"
                                placeholder="Contoh: Paket Basic" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-color-3 small">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control bg-color-1 text-color-4 border-secondary"
                                placeholder="150000" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-color-3 small">Durasi (Hari)</label>
                            <input type="number" name="day_duration"
                                class="form-control bg-color-1 text-color-4 border-secondary" placeholder="30" min="1"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-color-3 small">Status</label>
                            <select name="status" class="form-select bg-color-1 text-color-4 border-secondary">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_premium" id="isPremiumAdd" value="1">
                                <label class="form-check-label" for="isPremiumAdd">
                                    Paket Premium
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-color-2 fw-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Paket -->
    <?php if ($edit_package): ?>
        <div class="modal fade" id="modalEditPaket" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content bg-color-1 border border-secondary text-color-4">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title fw-bold">Edit Paket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="<?= BASE_URL ?>actions/save_package.php">
                        <input type="hidden" name="id_package" value="<?= $edit_package['id_package'] ?>">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label text-color-2 small">Nama Paket</label>
                                <input type="text" name="name" class="form-control bg-color-1 text-color-4 border-secondary"
                                    value="<?= escape($edit_package['name']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-color-2 small">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control bg-color-1 text-color-4 border-secondary"
                                    value="<?= $edit_package['price'] ?>" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-color-2 small">Durasi (Hari)</label>
                                <input type="number" name="day_duration"
                                    class="form-control bg-color-1 text-color-4 border-secondary"
                                    value="<?= $edit_package['day_duration'] ?>" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-color-2 small">Status</label>
                                <select name="status" class="form-select bg-color-1 text-color-4 border-secondary">
                                    <option value="Aktif" <?= $edit_package['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif
                                    </option>
                                    <option value="Nonaktif" <?= $edit_package['status'] === 'Nonaktif' ? 'selected' : '' ?>>
                                        Nonaktif</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_premium" id="isPremiumEdit" value="1" 
                                        <?= (bool)$edit_package['is_premium'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="isPremiumEdit">
                                        Paket Premium
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <a href="<?= BASE_URL ?>controllers/admin/packages_admin.php"
                                class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-color-2 fw-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Auto-buka modal edit kalau ada ?edit= di URL -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = new bootstrap.Modal(document.getElementById('modalEditPaket'));
                modal.show();
            });
        </script>
    <?php endif; ?>

</div>



