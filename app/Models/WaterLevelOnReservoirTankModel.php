<?php

namespace App\Models;

use CodeIgniter\Model;

class WaterLevelOnReservoirTankModel extends Model
{
    protected $table = 'water_level_on_recervoir_tank';
    protected $primaryKey = 'id_water_level_on_recervoir_tank';
    protected $allowedFields = ['id_cpp', 'awal_shift', 'akhir_shift', 'tanggal'];

    // Optional: Menambahkan validasi
    protected $validationRules = [
        'id_cpp' => 'required|integer',
        'awal_shift' => 'required|decimal',
        'akhir_shift' => 'required|decimal',
        'tanggal' => 'required|valid_date',
    ];

    public function insertData($data)
    {
        return $this->save($data);  // Menggunakan save untuk insert data
    }

    
    public function updateData($id, $data)
    {
        return $this->update($id, $data);  // Menggunakan update untuk memperbarui data
    }
}