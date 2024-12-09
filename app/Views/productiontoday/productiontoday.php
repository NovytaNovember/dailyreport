<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Today Files</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h3>Daftar File Production Today</h3>

        <!-- Tampilkan pesan sukses atau error -->
        <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $index => $file): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($file['nama_file']) ?></td>
                        <td><?= esc($file['upload_date']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="showEditModal(<?= $file['id'] ?>)">Edit</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit Data Production Today -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Production Today</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" action="" method="post">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Today</th>
                                        <th>Awal</th>
                                        <th>Akhir</th>
                                        <th>Total (Ton)</th>
                                    </tr>
                                </thead>
                                <tbody id="editTableBody">
                                    <!-- Data akan dimuat melalui JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showEditModal(fileId) {
        // Set form action URL for the update
        document.getElementById('editForm').action = '<?= base_url("productiontoday/updateProductionData") ?>/' +
        fileId;

        // Fetch data from server
        fetch('<?= base_url("productiontoday/getProductionData") ?>/' + fileId)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                console.log("Data received from server:", data); // Log respons JSON dari server
                if (data.error) {
                    alert(data.error);
                    return;
                }

                const tableBody = document.getElementById('editTableBody');
                tableBody.innerHTML = ''; // Bersihkan baris yang ada sebelumnya

                data.data.forEach((row, index) => {
                    const tr = document.createElement('tr');

                    // Beri nilai default jika kolom kosong atau null
                    const productToday = row[0] !== undefined && row[0] !== null ? row[0] : "";
                    const awal = !isNaN(row[1]) && row[1] !== null ? row[1] : "";
                    const akhir = !isNaN(row[2]) && row[2] !== null ? row[2] : "";
                    const total = !isNaN(row[3]) && row[3] !== null ? row[3] : "";

                    tr.innerHTML = `
                    <td><input type="text" name="productionData[${index}][product_today]" value="${productToday}" class="form-control" required></td>
                    <td><input type="number" name="productionData[${index}][awal]" value="${awal}" class="form-control"></td>
                    <td><input type="number" name="productionData[${index}][akhir]" value="${akhir}" class="form-control"></td>
                    <td><input type="number" name="productionData[${index}][total]" value="${total}" class="form-control"></td>
                `;
                    tableBody.appendChild(tr);
                });

                // Tampilkan modal setelah data dimuat
                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
    }
    </script>

</body>

</html>