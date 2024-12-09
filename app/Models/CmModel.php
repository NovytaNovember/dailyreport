<?php

namespace App\Models;

use CodeIgniter\Model;

class CmModel extends Model
{
    protected $table = 'cm';
    protected $primaryKey = 'id_cm';
    protected $allowedFields = [
        'id_cpp', 'no_cm', 'nama_cm', 'status_cm', 'tanggal'
    ];

    // Aturan validasi
    protected $validationRules = [
        'id_cpp' => 'required|integer',
        'no_cm' => 'required|integer',
        'nama_cm' => 'required|string|max_length[255]',
        'status_cm' => 'required|string|max_length[20]',
        'tanggal' => 'required|valid_date'
    ];

    public function insertCm($data)
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