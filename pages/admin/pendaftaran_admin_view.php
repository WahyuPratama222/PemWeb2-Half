<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-warning fw-bold mb-0">Data Pendaftaran Member</h4>
            <small class="text-white-50">
                Total: <?= count($pendaftaran) ?> Pendaftaran
            </small>
        </div>
    </div>

    <?php show_flash(); ?>

    <!-- Tabel -->
    <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
        <div class="table-responsive">
            <table class="table table-hover table-dark mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-warning">ID Reg</th>
                        <th class="text-warning">Nama Member</th>
                        <th class="text-warning">Email</th>
                        <th class="text-warning">Paket</th>
                        <th class="text-warning text-end">Harga</th>
                        <th class="text-warning">Tgl Daftar</th>
                        <th class="text-warning">Tgl Mulai</th>
                        <th class="text-warning">Tgl Expired</th>
                        <th class="text-warning text-center">Hari Tersisa</th>
                        <th class="text-warning">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendaftaran)): ?>
                        <tr>
                            <td colspan="10" class="text-center py-4 text-white-50">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                Belum ada data pendaftaran
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pendaftaran as $daftar): ?>
                            <?php 
                                $days_remaining = calculateDaysRemaining($daftar['expiry_date']);
                                $status_class = getStatusBadgeClass($daftar['status']);
                            ?>
                            <tr class="border-bottom border-secondary">
                                <td class="text-warning small">
                                    <strong>#<?= $daftar['id_registration'] ?></strong>
                                </td>
                                <td class="fw-bold">
                                    <?= escape($daftar['member_name']) ?>
                                </td>
                                <td class="text-white-50 small">
                                    <?= escape($daftar['email']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= escape($daftar['package_name']) ?>
                                    </span>
                                </td>
                                <td class="text-end text-warning fw-bold">
                                    <?= format_rupiah($daftar['price']) ?>
                                </td>
                                <td class="small">
                                    <?= format_date($daftar['registration_date']) ?>
                                </td>
                                <td class="small">
                                    <?= format_date($daftar['start_date']) ?>
                                </td>
                                <td class="small">
                                    <?= format_date($daftar['expiry_date']) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($daftar['status'] === 'active'): ?>
                                        <span class="badge bg-success">
                                            <?= $days_remaining ?> hari
                                        </span>
                                    <?php else: ?>
                                        <span class="text-white-50 small">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?= $status_class ?>">
                                        <?php
                                            echo match($daftar['status']) {
                                                'active'    => 'Aktif',
                                                'expired'   => 'Expired',
                                                'pending'   => 'Pending',
                                                'cancelled' => 'Dibatalkan',
                                                default     => $daftar['status']
                                            };
                                        ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mt-4">
        <div class="col-md-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
                <div class="card-body text-center">
                    <div class="fs-4 fw-bold text-success">
                        <?= count(array_filter($pendaftaran, fn($r) => $r['status'] === 'active')) ?>
                    </div>
                    <div class="small text-white-50">Membership Aktif</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
                <div class="card-body text-center">
                    <div class="fs-4 fw-bold text-danger">
                        <?= count(array_filter($pendaftaran, fn($r) => $r['status'] === 'expired')) ?>
                    </div>
                    <div class="small text-white-50">Membership Expired</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
                <div class="card-body text-center">
                    <div class="fs-4 fw-bold text-warning">
                        <?= count(array_filter($pendaftaran, fn($r) => $r['status'] === 'pending')) ?>
                    </div>
                    <div class="small text-white-50">Membership Pending</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary bg-opacity-10 border border-secondary text-white">
                <div class="card-body text-center">
                    <div class="fs-4 fw-bold text-info">
                        <?= 
                            count(array_filter($pendaftaran, fn($r) => $r['status'] === 'active')) +
                            count(array_filter($pendaftaran, fn($r) => $r['status'] === 'expired')) +
                            count(array_filter($pendaftaran, fn($r) => $r['status'] === 'pending')) +
                            count(array_filter($pendaftaran, fn($r) => $r['status'] === 'cancelled'))
                        ?>
                    </div>
                    <div class="small text-white-50">Total Pendaftaran</div>
                </div>
            </div>
        </div>
    </div>

</div>
