<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Progress Saya</h4>
            <small class="text-white-50">Catat progress anda untuk mencapai tujuan anda</small>
        </div>
        <span class="text-white-50 small"><?= date('d F Y') ?></span>
    </div>

    <?php show_flash(); ?>

    <!-- Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-warning bg-opacity-25">
                        <i class="bi bi-speedometer2 fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $progress['weight'] ?? '-' ?></div>
                        <div class="small text-white-50">Berat Badan (kg)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-info bg-opacity-25">
                        <i class="bi bi-arrows-vertical fs-4 text-info"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $progress['height'] ?? '-' ?></div>
                        <div class="small text-white-50">Tinggi Badan (cm)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-danger bg-opacity-25">
                        <i class="bi bi-droplet-fill fs-4 text-danger"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $progress['body_fat'] ?? '-' ?></div>
                        <div class="small text-white-50">Body Fat (%)</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-success bg-opacity-25">
                        <i class="bi bi-lightning-fill fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold"><?= $progress['muscle_mass'] ?? '-' ?></div>
                        <div class="small text-white-50">Muscle Mass (kg)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">

        <!-- Ukuran Tubuh -->
        <div class="col-md-5">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body">
                    <h6 class="text-white-50 mb-3"><i class="bi bi-rulers me-2"></i>Ukuran Tubuh</h6>
                    <div class="row g-3">
                        <?php
                            $metrics = [
                                ['label' => 'Dada',     'key' => 'chest'],
                                ['label' => 'Pinggang', 'key' => 'waist'],
                                ['label' => 'Bisep',    'key' => 'biceps'],
                                ['label' => 'Paha',     'key' => 'thigh'],
                            ];
                        ?>
                        <?php foreach ($metrics as $m): ?>
                            <div class="col-6">
                                <div class="p-3 rounded-3 border border-secondary text-center">
                                    <div class="fs-5 fw-bold text-warning">
                                        <?= $progress[$m['key']] ?? '-' ?>
                                        <?php if (!empty($progress[$m['key']])): ?>
                                            <span class="small text-white-50">cm</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="small text-white-50 mt-1"><?= $m['label'] ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Update -->
        <div class="col-md-7">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
                <div class="card-body">
                    <h6 class="text-white-50 mb-3"><i class="bi bi-pencil me-2"></i>Update Progress</h6>
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Berat Badan (kg)</label>
                                <input type="number" step="0.01" name="weight"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['weight'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Tinggi Badan (cm)</label>
                                <input type="number" step="0.01" name="height"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['height'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Body Fat (%)</label>
                                <input type="number" step="0.01" name="body_fat"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['body_fat'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Muscle Mass (kg)</label>
                                <input type="number" step="0.01" name="muscle_mass"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['muscle_mass'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Dada (cm)</label>
                                <input type="number" step="0.01" name="chest"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['chest'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Pinggang (cm)</label>
                                <input type="number" step="0.01" name="waist"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['waist'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Bisep (cm)</label>
                                <input type="number" step="0.01" name="biceps"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['biceps'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-warning">Paha (cm)</label>
                                <input type="number" step="0.01" name="thigh"
                                    class="form-control form-control-sm bg-dark text-white border-secondary"
                                    value="<?= escape($progress['thigh'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning btn-sm fw-semibold text-dark">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>