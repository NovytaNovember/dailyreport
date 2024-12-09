<?php

namespace App\Models;

use CodeIgniter\Model;

class UseOfKWHPLNtoCPPModel extends Model
{
    protected $table = 'use_of_kwh_pln_to_cpp';
    protected $primaryKey = 'id_use_of_kwh_pln_to_cpp';
    protected $allowedFields = [
        'id_cpp', 'awal', 'akhir', 'total_use', 'tanggal'
    ];

    // Aturan validasi untuk kolom
    protected $validationRules = [
        'id_cpp' => 'required|integer',  // ID CPP wajib diisi dan harus integer
        'awal' => 'required|decimal',    // Validasi dengan 'decimal' untuk tipe data float
        'akhir' => 'required|decimal',   // Validasi dengan 'decimal' untuk tipe data float
        'total_use' => 'required|decimal', // Validasi dengan 'decimal' untuk tipe data float
        'tanggal' => 'required|valid_date[Y-m-d]' // Validasi tanggal dengan format Y-m-d
    ];

    // Fungsi untuk menambah data baru ke dalam tabel
    public function insertData($data)
    {
        return $this->save($data);  // Fungsi save akan menambahkan data baru atau update jika ada ID yang sama
    }

    // Fungsi untuk mengupdate data berdasarkan id
    public function updateData($id, $data)
    {
        return $this->update($id, $data);  // Fungsi update digunakan untuk memperbarui data yang ada berdasarkan ID
    }
}