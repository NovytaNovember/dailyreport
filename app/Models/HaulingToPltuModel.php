<?php

namespace App\Models;

use CodeIgniter\Model;

class HaulingToPltuModel extends Model
{
    protected $table = 'hauling_to_pltu';
    protected $primaryKey = 'id_hauling_to_pltu';
    protected $allowedFields = [
        'id_cpp', 'no', 'hauling_to_pltu_explanation', 'rate',
        'time_from', 'time_to', 'duration_minutes', 'total_time', 'tanggal'
    ];

    // Fungsi untuk menyimpan data
    public function insertHaulingToPltu($data)
    {
        // Menyimpan data ke tabel hauling_to_pltu
        $insertResult = $this->insert($data);

        if (!$insertResult) {
            // Jika gagal insert, log pesan error
            log_message('error', 'Insert failed: ' . implode(', ', $this->errors()));
            return false;  // Return false jika gagal
        }

        return true;  // Return true jika sukses
    }
}