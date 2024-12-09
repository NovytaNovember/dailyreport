<?= $this->include('template/header') ?>
<?= $this->include('template/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
    .table-container {
        margin-top: 20px;
    }

    .btn-back {
        margin-bottom: 20px;
    }

    table {
        table-layout: auto;
        word-wrap: break-word;
    }
    </style>
</head>

<div class="content-body">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Hasil Pencarian Tabel: <?= ucfirst(str_replace('_', ' ', $table)) ?></h3>

                        <!-- Tombol Kembali -->
                        <a href="<?= base_url('cpp') ?>" class="btn btn-secondary btn-back">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        <!-- Tabel Hasil Pencarian -->
                        <div class="table-container">
                            <?php if (!empty($data)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <?php foreach (array_keys($data[0]) as $header): ?>
                                            <th><?= ucfirst(str_replace('_', ' ', $header)) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $row): ?>
                                        <tr>
                                            <?php foreach ($row as $value): ?>
                                            <td><?= esc($value) ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-circle"></i> Tidak ada data ditemukan berdasarkan
                                pencarian Anda.
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->include('template/footer') ?>