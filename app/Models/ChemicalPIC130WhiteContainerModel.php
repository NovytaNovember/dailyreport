<?php

namespace App\Models;

use CodeIgniter\Model;

class ChemicalPIC130WhiteContainerModel extends Model
{
    protected $table = 'chemical_pic130_white_container';
    protected $primaryKey = 'id_chemical_pic130_white_container';
    protected $allowedFields = [
        'id_cpp', 'based_awal_shift', 'based_akhir_shift', 'use_awal_shift',
        'use_akhir_shift', 'total_consumption', 'consumption', 'tanggal'
    ];

    // Aturan validasi yang benar
    protected $validationRules = [
        'id_cpp' => 'required|integer',
        'based_awal_shift' => 'required|decimal', // Menggunakan 'decimal' untuk tipe float
        'based_akhir_shift' => 'required|decimal', // Menggunakan 'decimal' untuk tipe float
        'use_awal_shift' => 'required|decimal', // Menggunakan 'decimal' untuk tipe float
        'use_akhir_shift' => 'required|decimal', // Menggunakan 'decimal' untuk tipe float
        'total_consumption' => 'required|decimal', // Menggunakan 'decimal' untuk tipe float
        'consumption' => 'required|decimal', // Menggunakan 'decimal' untuk tipe float
        'tanggal' => 'required|valid_date[Y-m-d]'  // Menambahkan validasi tanggal dengan format Y-m-d
    ];

    // Fungsi untuk mengambil data berdasarkan id_cpp
    public function getByIdCpp($id_cpp)
    {
        return $this->where('id_cpp', $id_cpp)->findAll();
    }

    // Fungsi untuk menambah data baru ke dalam tabel
    public function insertData($data)
    {
        // Jika tidak ada tanggal yang diberikan, set tanggal otomatis ke hari ini
        if (empty($data['tanggal'])) {
            $data['tanggal'] = date('Y-m-d');  // Menetapkan tanggal hari ini jika tidak ada yang diberikan
        }

        return $this->save($data);  // Fungsi save akan menambahkan data baru atau update jika ada ID yang sama
    }

    // Fungsi untuk mengupdate data berdasarkan id
    public function updateData($id, $data)
    {
        // Jika tidak ada tanggal yang diberikan, set tanggal otomatis ke hari ini
        if (empty($data['tanggal'])) {
            $data['tanggal'] = date('Y-m-d');  // Menetapkan tanggal hari ini jika tidak ada yang diberikan
        }

        return $this->update($id, $data);  // Fungsi update digunakan untuk memperbarui data yang ada berdasarkan ID
    }
}