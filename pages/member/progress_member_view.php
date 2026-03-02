<div class="container-fluid py-4">

    <!-- ── Header ── -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Progress Member</h4>
            <small class="text-white-50">
                Selamat datang, <?= escape(current_user()['name']) ?>
            </small>
        </div>
        <span class="text-white-50"><?= date('d F Y') ?></span>
    </div>

    <?php show_flash(); ?>

    <div class="card bg-secondary bg-opacity-10 border border-secondary text-white h-100">
        <div class="table-responsive">
            <table class="table table-hover table-dark align-middle mb-0">
                <thead>
                    <tr>
                        <th>Record Date</th>
                        <th>Weight (kg)</th>
                        <th>Height (cm)</th>
                        <th>Body Fat (%)</th>
                        <th>Muscle Mass (kg)</th>
                        <th>Chest (cm)</th>
                        <th>Waist (cm)</th>
                        <th>Biceps (cm)</th>
                        <th>Thigh (cm)</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="12" class="text-center text-secondary py-4">
                                Belum ada data.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $latestRow = $rows[0] ?? null; ?>
                        <?php foreach ($rows as $r): ?>
                            <tr>
                                <td><?= escape($r['record_date'] ?? '') ?></td>
                                <td><?= escape($r['weight'] ?? '') ?></td>
                                <td><?= escape($r['height'] ?? '') ?></td>
                                <td><?= escape($r['body_fat'] ?? '') ?></td>
                                <td><?= escape($r['muscle_mass'] ?? '') ?></td>
                                <td><?= escape($r['chest'] ?? '') ?></td>
                                <td><?= escape($r['waist'] ?? '') ?></td>
                                <td><?= escape($r['biceps'] ?? '') ?></td>
                                <td><?= escape($r['thigh'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex align-items-center mt-3">
        <button type="button" class="btn btn-warning btn-sm fw-semibold"
            data-bs-toggle="modal" data-bs-target="#modalAddProgress">
            + Tambah Progress
        </button>

        <div class="d-flex ms-auto gap-2">
            <button class="btn btn-outline-warning btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalEditProgress">
                Edit
            </button>

            <button class="btn btn-outline-danger btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalDeleteProgress">
                Delete
            </button>
        </div>
    </div>



    <div class="modal fade" id="modalAddProgress" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light" style="border-radius:14px;">
            <div class="modal-header border-secondary">
            <h5 class="modal-title fw-bold">Tambah Progress</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="">
            <input type="hidden" name="action" value="create_progress">

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Record Date (opsional)</label>
                        <input type="date" name="record_date" class="form-control form-control-sm">
                        <small class="text-white-50"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight" class="form-control form-control-sm">
                        <small class="text-white-50"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Height (cm)</label>
                        <input type="number" step="0.01" name="height" class="form-control form-control-sm">
                        <small class="text-white-50"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Body Fat (%)</label>
                        <input type="number" step="0.01" name="body_fat" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Muscle Mass (kg)</label>
                        <input type="number" step="0.01" name="muscle_mass" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Chest (cm)</label>
                        <input type="number" step="0.01" name="chest" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Waist (cm)</label>
                        <input type="number" step="0.01" name="waist" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Biceps (cm)</label>
                        <input type="number" step="0.01" name="biceps" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Thigh (cm)</label>
                        <input type="number" step="0.01" name="thigh" class="form-control form-control-sm">
                    </div>
                    
                </div>
            </div>

            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning btn-sm fw-semibold">Simpan</button>
            </div>
            </form>

            
        </div>
        </div>
    </div>

    <?php if ($latestRow): ?>
        <div class="modal fade" id="modalEditProgress" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-light" style="border-radius:14px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold">Edit Progress Terbaru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="">
                <input type="hidden" name="action" value="update_progress">
                <input type="hidden" name="id_progress" value="<?= escape($latestRow['id_progress']) ?>">

                <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                    <label class="form-label">Record Date</label>
                    <input type="date" name="record_date" class="form-control form-control-sm"
                            value="<?= escape($latestRow['record_date'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Weight</label>
                    <input type="number" step="0.01" name="weight" class="form-control form-control-sm"
                            value="<?= escape($latestRow['weight'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Height</label>
                    <input type="number" step="0.01" name="height" class="form-control form-control-sm"
                            value="<?= escape($latestRow['height'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Body Fat</label>
                    <input type="number" step="0.01" name="body_fat" class="form-control form-control-sm"
                            value="<?= escape($latestRow['body_fat'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Muscle Mass</label>
                    <input type="number" step="0.01" name="muscle_mass" class="form-control form-control-sm"
                            value="<?= escape($latestRow['muscle_mass'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Chest</label>
                    <input type="number" step="0.01" name="chest" class="form-control form-control-sm"
                            value="<?= escape($latestRow['chest'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Waist</label>
                    <input type="number" step="0.01" name="waist" class="form-control form-control-sm"
                            value="<?= escape($latestRow['waist'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Biceps</label>
                    <input type="number" step="0.01" name="biceps" class="form-control form-control-sm"
                            value="<?= escape($latestRow['biceps'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                    <label class="form-label">Thigh</label>
                    <input type="number" step="0.01" name="thigh" class="form-control form-control-sm"
                            value="<?= escape($latestRow['thigh'] ?? '') ?>">
                    </div>
                </div>

                </div>
                <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning btn-sm fw-semibold">Simpan Perubahan</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <?php endif; ?>

    <?php if ($latestRow): ?>
        <div class="modal fade" id="modalDeleteProgress" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light" style="border-radius:14px;">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-danger">Hapus Progress Terbaru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Kamu yakin mau menghapus progress tanggal terbaru
                <div class="text-white-50 small mt-2">Aksi ini tidak bisa dibatalkan.</div>
            </div>

            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>

                <form method="POST" action="" class="m-0">
                <input type="hidden" name="action" value="delete_progress">
                <input type="hidden" name="id_progress" value="<?= escape($latestRow['id_progress']) ?>">
                <button type="submit" class="btn btn-danger btn-sm fw-semibold">Ya, Hapus</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    <?php endif; ?>

    <div class="card card-dark mt-3 p-3">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
            <div>
            <h6 class="mb-0 text-warning fw-bold">Grafik Progress</h6>
            <small class="text-dark-50">Pilih data yang ingin ditampilkan</small>
            </div>

            <div class="ms-auto d-flex gap-2 align-items-center mx-3">
            <select id="metricSelect" class="form-select form-select-sm" style="width: 220px;">
                <option value="weight" data-unit="kg">Weight (kg)</option>
                <option value="height" data-unit="cm">Height (cm)</option>
                <option value="body_fat" data-unit="%">Body Fat (%)</option>
                <option value="muscle_mass" data-unit="kg">Muscle Mass (kg)</option>
                <option value="chest" data-unit="cm">Chest (cm)</option>
                <option value="waist" data-unit="cm">Waist (cm)</option>
                <option value="biceps" data-unit="cm">Biceps (cm)</option>
                <option value="thigh" data-unit="cm">Thigh (cm)</option>
            </select>
            </div>
        </div>

        <div style="height: 320px;">
            <canvas id="progressChart"></canvas>
        </div>
    </div>

<?php
    $chartLabels = array_map(fn($r) => $r['record_date'] ?? ('#'.$r['id_progress']), $chartRows ?? []);

    $chartSeries = [
    'weight'      => array_map(fn($r) => $r['weight'] ?? null, $chartRows ?? []),
    'height'      => array_map(fn($r) => $r['height'] ?? null, $chartRows ?? []),
    'body_fat'    => array_map(fn($r) => $r['body_fat'] ?? null, $chartRows ?? []),
    'muscle_mass' => array_map(fn($r) => $r['muscle_mass'] ?? null, $chartRows ?? []),
    'chest'       => array_map(fn($r) => $r['chest'] ?? null, $chartRows ?? []),
    'waist'       => array_map(fn($r) => $r['waist'] ?? null, $chartRows ?? []),
    'biceps'      => array_map(fn($r) => $r['biceps'] ?? null, $chartRows ?? []),
    'thigh'       => array_map(fn($r) => $r['thigh'] ?? null, $chartRows ?? []),
    ];
?>
<script>
    window.PROGRESS_CHART = {
        labels: <?= json_encode($chartLabels) ?>,
        series: <?= json_encode($chartSeries) ?>
    };
</script>

<script>
    (function () {
    const data = window.PROGRESS_CHART || { labels: [], series: {} };
    const ctx = document.getElementById('progressChart');
    const metricSelect = document.getElementById('metricSelect');

    function toNumberOrNull(x) {
        if (x === null || x === undefined || x === '') return null;
        const n = Number(x);
        return Number.isFinite(n) ? n : null;
    }

    function buildDataset(metricKey) {
    const raw = (data.series[metricKey] || []).map(toNumberOrNull);
    return { values: raw, labelSuffix: '' };
    }

    function unitOfSelected() {
        const opt = metricSelect.options[metricSelect.selectedIndex];
        return opt?.dataset?.unit || '';
    }

    // chart instance
    const initialMetric = metricSelect.value;
    const ds0 = buildDataset(initialMetric);

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
        labels: data.labels,
        datasets: [{
            label: initialMetric + ds0.labelSuffix,
            data: ds0.values,
            tension: 0.25,
            spanGaps: true,
            pointRadius: 3,
            pointHoverRadius: 5,
            borderWidth: 2,
        }]
        },
        options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true }
        },
        scales: {
            y: {
            ticks: {
                callback: function(value) {
                const u = unitOfSelected();
                return u ? `${value} ${u}` : value;
                }
            }
            }
        }
        }
    });
    function refresh() {
        const metricKey = metricSelect.value;
        const ds = buildDataset(metricKey);

        chart.data.datasets[0].label = metricKey + ds.labelSuffix;
        chart.data.datasets[0].data = ds.values;
        chart.update();
    }

    metricSelect.addEventListener('change', refresh);

    toggleCompare.addEventListener('click', () => {
        compareMode = !compareMode;
        toggleCompare.textContent = `Compare vs previous: ${compareMode ? 'ON' : 'OFF'}`;
        refresh();
    });
    
    })();
</script>

</div>