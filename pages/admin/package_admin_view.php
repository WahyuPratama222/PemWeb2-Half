<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Manajemen Paket</h4>
            <small class="text-white-50">Kelola paket membership gym</small>
        </div>
        <button class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahPaket">
            <i class="bi bi-plus-lg me-1"></i> Tambah Paket
        </button>
    </div>

    <?php show_flash(); ?>

    <!-- Tabel Paket -->
    <?php if (empty($packages)): ?>
        <div class="alert alert-warning text-dark-50">Belum ada paket tersedia.</div>
    <?php else: ?>
        <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-borderless mb-0">
                        <thead class="border-bottom border-secondary">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($packages as $i => $p): ?>
                                <tr>
                                    <td class="ps-4 text-white-50"><?= $i + 1 ?></td>
                                    <td class="fw-semibold"><?= escape($p['name']) ?></td>
                                    <td class="text-warning"><?= format_rupiah((float)$p['price']) ?></td>
                                    <td><?= escape($p['day_duration']) ?> Hari</td>
                                    <td>
                                        <?php if ($p['status'] === 'Aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="<?= BASE_URL ?>controllers/admin/packages_admin.php?edit=<?= $p['id_package'] ?>"
                                           class="btn btn-sm btn-outline-warning me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>actions/delete_package.php?id=<?= $p['id_package'] ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Hapus paket ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Modal Tambah Paket -->
<div class="modal fade" id="modalTambahPaket" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark border border-secondary text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Tambah Paket Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>actions/save_package.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-warning small">Nama Paket</label>
                        <input type="text" name="name" class="form-control bg-dark text-white border-secondary"
                               placeholder="Contoh: Paket Basic" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-warning small">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control bg-dark text-white border-secondary"
                               placeholder="150000" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-warning small">Durasi (Hari)</label>
                        <input type="number" name="day_duration" class="form-control bg-dark text-white border-secondary"
                               placeholder="30" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-warning small">Status</label>
                        <select name="status" class="form-select bg-dark text-white border-secondary">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Paket -->
<?php if ($edit_package): ?>
<div class="modal fade" id="modalEditPaket" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark border border-secondary text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Edit Paket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>actions/save_package.php">
                <input type="hidden" name="id_package" value="<?= $edit_package['id_package'] ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-warning small">Nama Paket</label>
                        <input type="text" name="name" class="form-control bg-dark text-white border-secondary"
                               value="<?= escape($edit_package['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-warning small">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control bg-dark text-white border-secondary"
                               value="<?= $edit_package['price'] ?>" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-warning small">Durasi (Hari)</label>
                        <input type="number" name="day_duration" class="form-control bg-dark text-white border-secondary"
                               value="<?= $edit_package['day_duration'] ?>" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-warning small">Status</label>
                        <select name="status" class="form-select bg-dark text-white border-secondary">
                            <option value="Aktif"    <?= $edit_package['status'] === 'Aktif'    ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?= $edit_package['status'] === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <a href="<?= BASE_URL ?>controllers/admin/packages_admin.php"
                       class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Simpan Perubahan</button>
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