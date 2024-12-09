<?php

namespace App\Controllers;

use App\Models\DataCsvModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel extends BaseController
{
    public function index()
    {
        $model = new DataCsvModel();

        // Mengambil semua data file CSV yang diunggah
        $data = [
            'title' => 'Production Today Files',
            'files' => $model->findAll(), // Mengambil data semua file
        ];

        return view('template/header', $data)
            . view('template/sidebar')
            . view('productiontoday/productiontoday', $data) // View untuk daftar file
            . view('template/footer');
    }

    public function getProductionData($id)
    {
        $model = new DataCsvModel();
        $fileData = $model->find($id);
    
        if (!$fileData) {
            return $this->response->setJSON(['error' => 'File tidak ditemukan']);
        }
    
        $filePath = WRITEPATH . 'uploads/' . $fileData['nama_file'];
    
        if (!file_exists($filePath)) {
            return $this->response->setJSON(['error' => 'File tidak ditemukan di server']);
        }
    
        // Baca file dan ambil data Production Today
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $dataRows = $sheet->toArray();
    
        // Filter data Production Today
        $productionData = [];
        $isProductionSection = false;
    
        foreach ($dataRows as $row) {
            // Deteksi bagian "Production Today" dengan kata kunci tertentu
            if (stripos($row[0], 'Production Today') !== false) {
                $isProductionSection = true;
                continue;
            }
    
            if ($isProductionSection) {
                if (empty(array_filter($row))) { // Hentikan jika menemukan baris kosong
                    break;
                }
                // Ambil hanya 4 kolom pertama (Product Today, Awal, Akhir, Total)
                $productionData[] = array_slice($row, 0, 4);
            }
        }
    
        // Konversi data menjadi JSON yang valid
        return $this->response->setJSON(['data' => $productionData]);
    }
    

    public function updateProductionData($id)
    {
        $model = new DataCsvModel();
        $fileData = $model->find($id);

        if (!$fileData) {
            return redirect()->to('/productiontoday')->with('error', 'File tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/' . $fileData['nama_file'];

        if (!file_exists($filePath)) {
            return redirect()->to('/productiontoday')->with('error', 'File tidak ditemukan di server.');
        }

        // Baca file dan update data berdasarkan input dari form
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Update data dari POST request
        $updatedData = $this->request->getPost('productionData');
        $rowIndex = 2; // Mulai dari baris kedua (tanpa header)

        foreach ($updatedData as $row) {
            $sheet->setCellValue('A' . $rowIndex, $row['product_today']);
            $sheet->setCellValue('B' . $rowIndex, $row['awal']);
            $sheet->setCellValue('C' . $rowIndex, $row['akhir']);
            $sheet->setCellValue('E' . $rowIndex, $row['total']);
            $rowIndex++;
        }

        // Simpan perubahan ke file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return redirect()->to('/productiontoday')->with('message', 'Data berhasil diperbarui.');
    }
}