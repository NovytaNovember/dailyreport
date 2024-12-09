<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityTodayModel extends Model
{
    protected $table = 'activity_today';
    protected $primaryKey = 'id_activity_today';
    protected $allowedFields = [
        'id_cpp', 'no', 'nama_activity_today', 'status_activity_today', 'tanggal'
    ];

    // Aturan validasi
    protected $validationRules = [
        'id_cpp' => 'required|integer',
        'no' => 'required|integer',
        'nama_activity_today' => 'required|string|max_length[255]',
        'status_activity_today' => 'required|string|max_length[20]',
        'tanggal' => 'required|valid_date'
    ];

    public function insertActivityToday($data)
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