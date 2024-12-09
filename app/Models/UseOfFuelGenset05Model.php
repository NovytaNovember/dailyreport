<?php

namespace App\Models;

use CodeIgniter\Model;

class UseOfFuelGenset05Model extends Model
{
    protected $table = 'use_of_fuel_genset05';
    protected $primaryKey = 'id_use_of_fuel_genset05';
    protected $allowedFields = [
        'id_cpp', 'input_awal', 'output_awal', 'kwh_awal', 'kvrah_awal', 'run_hour_awal',
        'input_akhir', 'output_akhir', 'kwh_akhir', 'kvrah_akhir', 'run_hour_akhir',
        'total_input_consumption', 'total_output_consumption', 'total_fuel_consumption',
        'total_kwh', 'total_kvarh', 'total_run_hour'
    ];

    // Aturan validasi yang benar
    protected $validationRules = [
        'id_cpp' => 'required|integer',
        'input_awal' => 'required|decimal',
        'output_awal' => 'required|decimal',
        'kwh_awal' => 'required|decimal',
        'kvrah_awal' => 'required|decimal',
        'run_hour_awal' => 'required|decimal',
        'input_akhir' => 'required|decimal',
        'output_akhir' => 'required|decimal',
        'kwh_akhir' => 'required|decimal',
        'kvrah_akhir' => 'required|decimal',
        'run_hour_akhir' => 'required|decimal',
        'total_input_consumption' => 'required|decimal',
        'total_output_consumption' => 'required|decimal',
        'total_fuel_consumption' => 'required|decimal',
        'total_kwh' => 'required|decimal',
        'total_kvarh' => 'required|decimal',
        'total_run_hour' => 'required|decimal'
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