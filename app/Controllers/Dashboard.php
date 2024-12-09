<?php

namespace App\Controllers;

use App\Models\CppModel; // Memastikan model CppModel digunakan
use PhpOffice\PhpSpreadsheet\IOFactory;

class Dashboard extends BaseController
{
    public function index()
    {
        $cppModel = new CppModel(); // Menggunakan model CppModel untuk mendapatkan data file CPP
        $dataCpp = $cppModel->findAll();

        // Inisialisasi jumlah file berdasarkan tipe dan jenis
        $fileTypesCount = [
            'XLS' => 0,
            'CSV' => 0,
            'XLSX' => 0,
        ];
        $jenisFileCount = [
            'CPP' => 0,
            'PORT' => 0,
        ];

        // Loop melalui data CPP untuk menghitung jumlah berdasarkan tipe file dan jenis file
        foreach ($dataCpp as $row) {
            $fileExtension = pathinfo($row['nama_cpp'], PATHINFO_EXTENSION);

            switch (strtolower($fileExtension)) {
                case 'xls':
                    $fileTypesCount['XLS']++;
                    break;
                case 'csv':
                    $fileTypesCount['CSV']++;
                    break;
                default:
                    $fileTypesCount['XLSX']++;
                    break;
            }

            // Menghitung jumlah berdasarkan jenis file (CPP atau PORT)
            if (isset($row['jenis_file'])) {
                if (strtoupper($row['jenis_file']) === 'CPP') {
                    $jenisFileCount['CPP']++;
                } elseif (strtoupper($row['jenis_file']) === 'PORT') {
                    $jenisFileCount['PORT']++;
                }
            }
        }

        // Data yang akan dikirimkan ke view dashboard
        $data = [
            'title' => 'Dashboard',
            'fileTypesCount' => $fileTypesCount,
            'jenisFileCount' => $jenisFileCount,
        ];

        return view('template/header', $data)
            . view('template/sidebar')
            . view('dashboard/dashboard', $data)
            . view('template/footer');
    }
}