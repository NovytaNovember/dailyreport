<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Cetaklaporan extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Upload Excel'];
        return view('template/header', $data)
            . view('template/sidebar')
            . view('export_excel')
            . view('template/footer');
    }

    public function cetakLaporanCpp()
    {
        // View untuk Cetak Laporan CPP
        return view('template/header', ['title' => 'Laporan CPP'])
            . view('template/sidebar')
            . view('cetak_laporan_cpp')
            . view('template/footer');
    }

    public function cetakLaporanPort()
    {
        // View untuk Cetak Laporan Port
        return view('template/header', ['title' => 'Laporan Port'])
            . view('template/sidebar')
            . view('cetak_laporan_port')
            . view('template/footer');
    }
}