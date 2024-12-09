<?= $this->include('template/header') ?>
<?= $this->include('template/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CSV/XLS/XLSX Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
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

    /* Modal Styles */
    .modal-content {
        border-radius: 8px;
        padding: 20px;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-bottom: 2px solid #0056b3;
    }

    .modal-header h5 {
        font-size: 18px;
    }

    .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-footer {
        border-top: 2px solid #eee;
    }

    /* Table Styles for Modal */
    .table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table th {
        background-color: #f1f1f1;
        color: #333;
        font-weight: bold;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #ffffff;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    /* Adjust modal content overflow for better scroll */
    #rincianContent,
    #editContent {
        overflow-x: auto;
    }

    /* Input styling inside modal */
    .modal-body input,
    .modal-body select {
        margin-bottom: 10px;
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .modal-body textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        height: 120px;
    }

    .modal-body button {
        margin-top: 10px;
    }
    </style>
</head>

<div class="content-body">
    <div class="container-fluid mt-4">
        <!-- Form Upload File -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Upload File (CSV / XLS / XLSX)</h4>
                        <form action="<?= base_url('cpp/uploadFile') ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="upload_date">Tanggal Upload</label>
                                <input type="date" name="upload_date" id="upload_date" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="file">File</label>
                                <input type="file" name="file_upload" accept=".csv, .xls, .xlsx" class="form-control"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Upload</button>
                        </form>
                        <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success mt-3"><?= session()->getFlashdata('message') ?></div>
                        <?php elseif (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mt-3"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tabel Data CPP -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <h3>Manajemen File CSV / XLS / XLSX</h3>
                        <form method="get" action="<?= base_url('cpp/search') ?>" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="table" class="form-control" required>
                                        <option value="">Pilih Tabel</option>
                                        <option value="production_today">Production Today</option>
                                        <option value="total_ritase">Total Ritase</option>
                                        <option value="use_of_heavy_vehicles">Use of Heavy Vehicles</option>
                                        <option value="cpp_runtime">CPP Runtime</option>
                                        <option value="olc_runtime">OLC Runtime</option>
                                        <option value="daily_stock_cpp">Daily Stock CPP</option>
                                        <option value="daily_tank_cap">Daily Tank Cap</option>
                                        <option value="water_level_on_settling_pond">Water Level On Settling Pond
                                        </option>
                                        <option value="water_level_on_reservoir_tank">Water Level On Reservoir Tank
                                        </option>
                                        <option value="chemical_startron_grey_container">Chemical Startron Grey
                                            Container</option>
                                        <option value="chemical_pic130_white_container">Chemical PIC 130 White
                                            Container</option>
                                        <option value="use_of_kwh_pln_cpp">Use Of KWH PLN to CPP</option>
                                        <option value="use_of_fuel_genset04">Use Of Fuel Genset 04 </option>
                                        <option value="use_of_fuel_genset05">Use Of Fuel Genset 05 </option>
                                        <option value="activity_today">Activity Today</option>
                                        <option value="pm">Pm</option>
                                        <option value="cm">Cm</option>
                                        <option value="hauling_to_pltu">Hauling To Pltu</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="startDate" class="form-control" placeholder="Tanggal Awal">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="endDate" class="form-control" placeholder="Tanggal Akhir">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dataCpp) && is_array($dataCpp)): ?>
                                <?php foreach ($dataCpp as $index => $cpp): ?>
                                <tr>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= esc($cpp['nama_cpp']); ?></td>
                                    <td><?= date('Y-m-d H:i:s', strtotime($cpp['upload_date'])); ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm"
                                            onclick="showRincianModal(<?= $cpp['id_cpp'] ?>)">Rincian</button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="showEditModal(<?= $cpp['id_cpp'] ?>)">Edit</button>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="showDeleteModal(<?= $cpp['id_cpp'] ?>)">Hapus</button>
                                        <a href="<?= base_url('cpp/download/' . $cpp['id_cpp']) ?>"
                                            class="btn btn-success btn-sm">Download</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Data Found</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Rincian -->
<div class="modal fade" id="rincianModal" tabindex="-1" aria-labelledby="rincianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rincianModalLabel">Rincian File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="rincianContent" style="overflow-y: auto; max-height: 60vh;">
                <!-- Konten rincian akan dimuat di sini -->
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data CPP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editContent" style="overflow-y: auto; max-height: 60vh;">
                <!-- Isi modal edit -->
            </div>
        </div>
    </div>
</div>



<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data CPP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus file ini?
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('cpp/delete') ?>" method="post">
                    <input type="hidden" name="id_cpp" id="deleteIdCpp">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Search -->
<!-- Modal untuk Hasil Pencarian -->
<div class="modal fade" id="searchResultModal" tabindex="-1" aria-labelledby="searchResultModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchResultModalLabel">Hasil Pencarian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="searchResultContent" style="overflow-y: auto; max-height: 80vh;">
                    <!-- Konten hasil pencarian akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Fungsi untuk menampilkan rincian modal
function showRincianModal(id) {
    $.get('<?= base_url('cpp/rincian/') ?>' + id, function(data) {
        $('#rincianContent').html(data); // Mengisi konten rincian
        new bootstrap.Modal(document.getElementById('rincianModal')).show(); // Menampilkan modal
    }).fail(function() {
        alert('Gagal memuat rincian file.');
    });
}

// Fungsi untuk menampilkan edit modal
function showEditModal(id) {
    $.get('<?= base_url('cpp/edit/') ?>' + id, function(data) {
        $('#editContent').html(data); // Mengisi konten edit
        new bootstrap.Modal(document.getElementById('editModal')).show(); // Menampilkan modal
    }).fail(function() {
        alert('Gagal memuat data edit.');
    });
}

// Fungsi untuk menampilkan modal hapus
function showDeleteModal(id) {
    $('#deleteIdCpp').val(id); // Set nilai ID untuk hapus
    new bootstrap.Modal(document.getElementById('deleteModal')).show(); // Menampilkan modal hapus
}

// Event listener untuk memastikan tombol close modal berfungsi
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-close, .btn-secondary[data-bs-dismiss="modal"]').forEach(button => {
        button.addEventListener('click', () => {
            const modal = bootstrap.Modal.getInstance(button.closest('.modal'));
            if (modal) {
                modal.hide();
            }
        });
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->include('template/footer') ?>