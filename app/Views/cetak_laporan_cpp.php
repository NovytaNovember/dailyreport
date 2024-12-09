<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Export Excel Berdasarkan Tanggal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .content-body {
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="content-body">

                    <h3 class="mb-4">Cetak Laporan Berdasarkan Tanggal</h3>

                    <form id="dataForm">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Pilih Tanggal:</label>
                            <input type="date" id="tanggal" class="form-control" required>
                        </div>

                        <button type="button" class="btn btn-success" onclick="exportToExcel()">Export ke Excel</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SheetJS untuk Export Excel -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <script>
        function exportToExcel() {
            const tanggal = document.getElementById('tanggal').value;

            if (!tanggal) {
                alert("Harap pilih tanggal sebelum mengekspor.");
                return;
            }

            // Ambil data berdasarkan tanggal
            // Untuk contoh ini, kita menggunakan data statis
            const data = [{
                    Nama: "John Doe",
                    Email: "john@example.com",
                    Tanggal: "2023-11-01"
                },
                {
                    Nama: "Jane Smith",
                    Email: "jane@example.com",
                    Tanggal: "2023-11-01"
                },
                {
                    Nama: "David Lee",
                    Email: "david@example.com",
                    Tanggal: "2023-11-02"
                }
            ];

            // Filter data berdasarkan tanggal yang dipilih
            const filteredData = data.filter(item => item.Tanggal === tanggal);

            if (filteredData.length === 0) {
                alert("Tidak ada data yang sesuai untuk tanggal yang dipilih.");
                return;
            }

            // Konversi data menjadi worksheet
            const worksheet = XLSX.utils.json_to_sheet(filteredData);

            // Buat workbook dan tambahkan worksheet
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Data");

            // Ekspor file Excel
            XLSX.writeFile(workbook, `data-${tanggal}.xlsx`);
        }
    </script>

</body>

</html>