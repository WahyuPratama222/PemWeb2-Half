<div class="container-fluid py-4">

    <!-- ── Header ── -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Progress Member</h4>
            <small class="text-white-50">
                Lihat semua progressmu disini
            </small>
        </div>
        <span class="text-white-50"><?= date('d F Y') ?></span>
    </div>

    <?php show_flash(); ?>

    <?php
    $preset = $preset ?? 'all';

    $targetDate = null;
    $now = new DateTime(date('Y-m-d'));

    switch ($preset) {
    case 'week':    $targetDate = (clone $now)->modify('-7 days'); break;
    case 'month':   $targetDate = (clone $now)->modify('-1 month'); break;
    case 'quarter': $targetDate = (clone $now)->modify('-3 months'); break;
    case 'year':    $targetDate = (clone $now)->modify('-1 year'); break;
    case 'all':
    default:        $targetDate = null; break;
    }

    $latest = null;
    $baseline = null;
    $baseline_is_nearest = false;
    $baseline_target_str = null;

    if (!empty($rows)) {
    $latest = $rows[0];

    if ($preset === 'all') {
        $baseline = $rows[count($rows) - 1];
    } else {
        $baseline_target_str = $targetDate ? $targetDate->format('Y-m-d') : null;

        foreach ($rows as $r) {
        $rd = $r['record_date'] ?? null;
        if (!$rd) continue;

        if ($rd <= $baseline_target_str) {
            $baseline = $r;
            break;
        }
        }

        if (!$baseline) {
        $baseline = $rows[count($rows) - 1];
        $baseline_is_nearest = true;
        } else {
        $baseline_is_nearest = ($baseline['record_date'] !== $baseline_target_str);
        }
    }
    }

    $delta = function($new, $old) {
    if ($new === '' || $new === null || $old === '' || $old === null) return null;
    return (float)$new - (float)$old;
    };

    $fmtDelta = function($d, $unit) {
    if ($d === null) return '-';

    $abs = abs((float)$d);
    $isInt = (abs($abs - round($abs)) < 0.00001);
    $num = $isInt ? (string)(int)round($abs) : number_format($abs, 2);

    if ($d > 0) $sign = '+';
    elseif ($d < 0) $sign = '-';
    else $sign = '';

    return $sign . $num . ' ' . $unit;
    };

    $metrics = [
    ['key' => 'weight',      'label' => 'Weight',      'unit' => 'kg', '%border' => 'warning'],
    ['key' => 'height',      'label' => 'Height',      'unit' => 'cm', '%border' => 'info'],
    ['key' => 'body_fat',    'label' => 'Body Fat',    'unit' => '%',  '%border' => 'primary'],
    ['key' => 'muscle_mass', 'label' => 'Muscle Mass', 'unit' => 'kg', '%border' => 'success'],
    ['key' => 'chest',       'label' => 'Chest',       'unit' => 'cm', '%border' => 'light'],
    ['key' => 'waist',       'label' => 'Waist',       'unit' => 'cm', '%border' => 'secondary'],
    ['key' => 'biceps',      'label' => 'Biceps',      'unit' => 'cm', '%border' => 'danger'],
    ['key' => 'thigh',       'label' => 'Thigh',       'unit' => 'cm', '%border' => 'warning'],
    ];

    $presetLabel = [
    'week' => 'Week',
    'month' => 'Month',
    'quarter' => 'Quarter',
    'year' => 'Year',
    'all' => 'All time',
    ][$preset] ?? 'All time';
    ?>

<?php if (!empty($rows)): ?>
    <div class="card bg-secondary bg-opacity-10 border border-secondary text-white mb-3">
        <div class="card-body py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div class="fw-semibold text-warning">Grafik Progress</div>
                
                <div class="d-flex align-items-center gap-2">
                    <select id="chartMetric" class="form-select form-select-sm bg-dark text-light border-secondary">
                        <option value="weight">Weight (kg)</option>
                        <option value="height">Height (cm)</option>
                        <option value="body_fat">Body Fat (%)</option>
                        <option value="muscle_mass">Muscle Mass (kg)</option>
                        <option value="chest">Chest (cm)</option>
                        <option value="waist">Waist (cm)</option>
                        <option value="biceps">Biceps (cm)</option>
                        <option value="thigh">Thigh (cm)</option>
                    </select>

                    <select id="chartTime" class="form-select form-select-sm bg-dark text-light border-secondary">
                        <option value="week">Week</option>
                        <option value="month">Month</option>
                        <option value="quarter">Quarter</option>
                        <option value="year">Year</option>
                        <option value="all" selected>All time</option>
                    </select>
                </div>
            </div>

            <div style="position: relative; height:300px; width:100%">
                <canvas id="progressChart"></canvas>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($rows) && $latest && $baseline): ?>
        <div class="card bg-secondary bg-opacity-10 border border-secondary text-white mb-3">
            <div class="card-body py-3">

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <div>
                    <div class="fw-semibold text-warning">Perkembangan Progress</div>
                    <div class="small text-white-50">
                        <strong><?= escape($baseline['record_date'] ?? '-') ?></strong>
                        &nbsp;→&nbsp;
                        <strong><?= escape($latest['record_date'] ?? '-') ?></strong>
                    </div>
                    </div>

                    <form method="POST" action="" class="m-0 d-flex align-items-center gap-2">
                    <input type="hidden" name="action" value="set_compare_preset">
                    <div class="small text-white-50 d-none d-md-block">Bandingkan:</div>
                    <select name="preset" class="form-select form-select-sm bg-dark text-light border-secondary"
                        onchange="this.form.submit()">
                        <option value="week"    <?= ($preset==='week') ? 'selected' : '' ?>>Week</option>
                        <option value="month"   <?= ($preset==='month') ? 'selected' : '' ?>>Month</option>
                        <option value="quarter" <?= ($preset==='quarter') ? 'selected' : '' ?>>Quarter</option>
                        <option value="year"    <?= ($preset==='year') ? 'selected' : '' ?>>Year</option>
                        <option value="all"     <?= ($preset==='all') ? 'selected' : '' ?>>All time</option>
                    </select>
                    </form>
                </div>

                <div class="row g-3">
                    <?php foreach ($metrics as $m): ?>
                    <?php
                        $key = $m['key'];
                        $d = $delta($latest[$key] ?? null, $baseline[$key] ?? null);
                        $text = $fmtDelta($d, $m['unit']);

                        $textClass = 'text-light';
                        if ($d !== null) {
                        if ($d > 0) $textClass = 'text-success';
                        elseif ($d < 0) $textClass = 'text-danger';
                        }
                    ?>

                    <div class="col-6 col-md-3">
                        <div class="text-center">
                        <div class="fw-semibold mb-1"><?= escape($m['label']) ?></div>

                        <div class="d-flex align-items-center justify-content-center rounded-circle border border-warning"
                            style="width:92px;height:92px;margin:0 auto;border-width:2px !important;">
                            <div class="fw-bold <?= $textClass ?>">
                            <?= $text ?>
                            </div>
                        </div>

                        <div class="small text-white-50 mt-1">
                            <?= escape($baseline[$key] ?? '-') ?> → <?= escape($latest[$key] ?? '-') ?>
                        </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

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
                        <th></th>
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
                        <?php $displayRows = $rows;
                            if (empty($show_all)) {
                                $displayRows = array_slice($rows, 0, 1); // hanya teratas
                            }
                        ?>
                        <?php if (!empty($rows)): ?>
                            <div class="m-2 text-white-50 small">
                                Menampilkan <?= empty($show_all) ? 1 : count($rows) ?> dari <?= count($rows) ?> data.
                            </div>
                        <?php endif; ?>

                        <?php foreach ($displayRows as $r): ?>
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
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <button type="button" class="btn btn-outline-warning btn-sm fw-semibold"
                                            data-bs-toggle="modal" data-bs-target="#modalEditProgress<?= (int)$r['id_progress'] ?>">
                                        Edit
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm fw-semibold"
                                            data-bs-toggle="modal" data-bs-target="#modalDeleteProgress<?= (int)$r['id_progress'] ?>">
                                        Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <?php $pid = (int)($r['id_progress'] ?? 0); ?>
                                <div class="modal fade" id="modalEditProgress<?= $pid ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content bg-dark text-light" style="border-radius:14px;">
                                            <div class="modal-header border-secondary">
                                                <h5 class="modal-title fw-bold">Edit Progress</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form method="POST" action="">
                                                <input type="hidden" name="action" value="update_progress">
                                                <input type="hidden" name="id_progress" value="<?= $pid ?>">

                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Record Date</label>
                                                            <input type="date" name="record_date" class="form-control form-control-sm"
                                                            value="<?= escape($r['record_date'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Weight (kg)</label>
                                                            <input type="number" step="0.01" name="weight" class="form-control form-control-sm"
                                                            value="<?= escape($r['weight'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Height (cm)</label>
                                                            <input type="number" step="0.01" name="height" class="form-control form-control-sm"
                                                            value="<?= escape($r['height'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Body Fat (%)</label>
                                                            <input type="number" step="0.01" name="body_fat" class="form-control form-control-sm"
                                                            value="<?= escape($r['body_fat'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Muscle Mass (kg)</label>
                                                            <input type="number" step="0.01" name="muscle_mass" class="form-control form-control-sm"
                                                            value="<?= escape($r['muscle_mass'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Chest (cm)</label>
                                                            <input type="number" step="0.01" name="chest" class="form-control form-control-sm"
                                                            value="<?= escape($r['chest'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Waist (cm)</label>
                                                            <input type="number" step="0.01" name="waist" class="form-control form-control-sm"
                                                            value="<?= escape($r['waist'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Biceps (cm)</label>
                                                            <input type="number" step="0.01" name="biceps" class="form-control form-control-sm"
                                                                value="<?= escape($r['biceps'] ?? '') ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label">Thigh (cm)</label>
                                                            <input type="number" step="0.01" name="thigh" class="form-control form-control-sm"
                                                                value="<?= escape($r['thigh'] ?? '') ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning btn-sm fw-semibold">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalDeleteProgress<?= $pid ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content bg-dark text-light" style="border-radius:14px;">
                                            <div class="modal-header border-secondary">
                                                <h5 class="modal-title fw-bold text-danger">Hapus Progress</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form method="POST" action="">
                                                <input type="hidden" name="action" value="delete_progress">
                                                <input type="hidden" name="id_progress" value="<?= $pid ?>">

                                                <div class="modal-body">
                                                    <p class="mb-2">Yakin mau hapus progress tanggal:</p>
                                                    <div class="p-2 bg-secondary bg-opacity-25 rounded">
                                                        <strong><?= escape($r['record_date'] ?? '') ?></strong>
                                                    </div>
                                                    <small class="text-white-50 d-block mt-2">Aksi ini tidak bisa dibatalkan.</small>
                                                </div>

                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger btn-sm fw-semibold">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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

        <?php if (!empty($rows)): ?>
            <form method="POST" action="" class="mx-4">
                <input type="hidden" name="action" value="toggle_progress_show">
                <button type="submit" class="btn btn-outline-light btn-sm fw-semibold">
                    <?= !empty($show_all) ? 'Tampilkan Lebih Sedikit' : 'Tampilkan Lebih Banyak' ?>
                </button>
            </form>
        <?php endif; ?>
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
                                    <label class="form-label">Record Date</label>
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

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Ambil data mentah dari PHP dan ubah menjadi Array JavaScript
    const rawData = <?= json_encode($rows ?? []) ?>;
    if (rawData.length === 0) return;

    // Balik urutan data agar dari yang terlama ke yang terbaru (kiri ke kanan untuk grafik)
    const chartData = rawData.slice().reverse(); 
    
    // Ambil elemen DOM
    const ctx = document.getElementById('progressChart').getContext('2d');
    const metricSelect = document.getElementById('chartMetric');
    const timeSelect = document.getElementById('chartTime');
    
    let progressChart; // Variabel untuk menyimpan instance chart

    // Fungsi untuk memfilter data berdasarkan pilihan waktu
function getFilteredData(data, timeScale) {
        let filtered = [];

        // 1. Dapatkan rentang waktu yang sesuai terlebih dahulu
        if (timeScale === 'all') {
            filtered = data;
        } else {
            const latestDateStr = data[data.length - 1].record_date;
            const targetDate = new Date(latestDateStr);

            if (timeScale === 'week') targetDate.setDate(targetDate.getDate() - 7);
            else if (timeScale === 'month') targetDate.setMonth(targetDate.getMonth() - 1);
            else if (timeScale === 'quarter') targetDate.setMonth(targetDate.getMonth() - 3);
            else if (timeScale === 'year') targetDate.setFullYear(targetDate.getFullYear() - 1);

            filtered = data.filter(item => new Date(item.record_date) >= targetDate);
        }

        const MAX_POINTS = 12;
        
        if (filtered.length > MAX_POINTS) {
            const sampled = [];
            const step = (filtered.length - 1) / (MAX_POINTS - 1);

            for (let i = 0; i < MAX_POINTS; i++) {
                const index = Math.round(i * step);
                sampled.push(filtered[index]);
            }
            
            return sampled;
        }
        return filtered;
    }

    // Fungsi untuk merender/memperbarui grafik
    function updateChart() {
        const metric = metricSelect.value;
        const metricLabel = metricSelect.options[metricSelect.selectedIndex].text;
        const timeScale = timeSelect.value;

        // Terapkan filter waktu
        const filteredData = getFilteredData(chartData, timeScale);

        // Siapkan Label (Tanggal) dan Dataset (Angka)
        const labels = filteredData.map(item => item.record_date);
        const dataPoints = filteredData.map(item => item[metric]);

        // Hancurkan grafik lama jika sudah ada (mencegah tumpuk)
        if (progressChart) {
            progressChart.destroy();
        }

        // Buat grafik baru
        progressChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: metricLabel,
                    data: dataPoints,
                    borderColor: '#ffc107', // Warna text-warning Bootstrap
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#212529',
                    pointBorderColor: '#ffc107',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3 // Membuat garis agak melengkung
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend utama karena sudah ada judul di dropdown
                    },
                    tooltip: {
                        theme: 'dark'
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: 'rgba(255, 255, 255, 0.7)' }
                    },
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.1)' },
                        ticks: { color: 'rgba(255, 255, 255, 0.7)' },
                        // Jangan mulai dari 0 agar fluktuasi grafik terlihat jelas
                        beginAtZero: false 
                    }
                }
            }
        });
    }

    // Jalankan pertama kali saat halaman dimuat
    updateChart();

    // Beri event listener jika dropdown berubah
    metricSelect.addEventListener('change', updateChart);
    timeSelect.addEventListener('change', updateChart);
});
</script>
</div>