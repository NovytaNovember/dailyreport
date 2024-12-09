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
    .content-body {
        padding: 20px;
    }

    .table-responsive {
        margin-top: 15px;
    }

    /* Styling untuk ikon pencarian di dalam input */
    .search-input-group {
        position: relative;
    }

    .search-input-group input {
        padding-left: 2.5rem;
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
    }
    </style>
</head>

<body>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-body">
                    <div class="row mb-4">
                        <!-- Card Jumlah File CPP -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">File CPP</h5>
                                    <p class="card-text"><?= $jenisFileCount['CPP'] ?></p> <!-- Jumlah file CPP -->
                                </div>
                            </div>
                        </div>

                        <!-- Card Jumlah File PORT -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">File PORT</h5>
                                    <p class="card-text"><?= $jenisFileCount['PORT'] ?></p> <!-- Jumlah file PORT -->
                                </div>
                            </div>
                        </div>

                        <!-- Card File CSV -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">File CSV</h5>
                                    <p class="card-text"><?= $fileTypesCount['CSV'] ?></p> <!-- Jumlah file CSV -->
                                </div>
                            </div>
                        </div>

                        <!-- Card File XLSX -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">File XLSX</h5>
                                    <p class="card-text"><?= $fileTypesCount['XLSX'] ?></p> <!-- Jumlah file XLSX -->
                                </div>
                            </div>
                        </div>

                        <!-- Card File XLS -->
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">File XLS</h5>
                                    <p class="card-text"><?= $fileTypesCount['XLS'] ?></p> <!-- Jumlah file XLS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>