<?php

namespace App\Models;

use CodeIgniter\Model;

class PmModel extends Model
{
    protected $table = 'pm';
    protected $primaryKey = 'id_pm';
    protected $allowedFields = [
        'id_cpp', 'no_pm', 'nama_pm', 'status_pm', 'tanggal'
    ];

    // Aturan validasi
    protected $validationRules = [
        'id_cpp' => 'required|integer',  // Validasi id_cpp
        'no_pm' => 'required|integer',
        'nama_pm' => 'required|string|max_length[255]',
        'status_pm' => 'required|string|max_length[20]',
        'tanggal' => 'required|valid_date'
    ];

    public function insertPm($data)
    {
        // Validasi data
        if ($this->validate($data)) {
            // Insert data jika valid
            $result = $this->insert($data);
            if (!$result) {
                log_message('error', 'Insert failed: ' . implode(', ', $this->errors())); // Log error jika insert gagal
                return false; // Jika gagal, kembalikan false
            }
            return true;
        } else {
            // Jika data tidak valid, log error validasi
            log_message('error', 'Validation failed: ' . implode(', ', $this->errors()));
            return false;
        }
    }
}