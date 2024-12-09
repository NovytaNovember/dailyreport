<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CSV/XLS/XLSX Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
    /* Styling untuk mencegah overlap dan padding */
    .content-body {
        padding: 20px;
    }

    .search-container {
        position: relative;
        width: 100%;
    }

    .search-container input {
        width: 100%;
        padding-left: 2.5rem;
        border-radius: 5px;
        border: 1px solid #ced4da;
    }

    .search-container .search-icon {
        position: absolute;
        top: 50%;
        left: 0.75rem;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .table-responsive {
        margin-top: 15px;
    }
    </style>
</head>

<body>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-body">
                    <div class="row">

                    </div>

                    <!-- Form Upload File -->
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Upload File (CSV / XLS / XLSX)</h4>
                                    <form action="<?= base_url('dashboard/uploadFile') ?>" method="post"
                                        enctype="multipart/form-data">

                                        <!-- Form Input Tanggal -->
                                        <div class="form-group">
                                            <label for="upload_date">Tanggal Upload:</label>
                                            <input type="date" name="upload_date" id="upload_date" class="form-control"
                                                required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="file_upload">File Upload:</label>
                                            <input type="file" name="file_upload" id="file_upload"
                                                accept=".csv, .xls, .xlsx" class="form-control" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Upload</button>
                                    </form>

                                    <?php if (session()->getFlashdata('message')): ?>
                                    <div class="alert alert-success mt-3"><?= session()->getFlashdata('message') ?>
                                    </div>
                                    <?php elseif (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger mt-3"><?= session()->getFlashdata('error') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk Search Functionality -->
    <script>
    document.getElementById('searchInput').addEventListener('input', filterTable);

    function filterTable() {
        const filter = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            const nama = row.cells[1].textContent.toLowerCase();
            const email = row.cells[2].textContent.toLowerCase();

            if (nama.includes(filter) || email.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    </script>

</body>

</html>