<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyStockCppModel extends Model
{
    protected $table = 'daily_stock_cpp'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key tabel
    protected $allowedFields = [
        'id_cpp',
        'awal_shift',
        'akhir_shift',
        'supply',
        'total_consumption',
        'tanggal',
        'awal_shift_flow',
        'akhir_shift_flow',
    ];

    /**
     * Perbarui data berdasarkan ID CPP.
     *
     * @param int $id_cpp
     * @param array $data
     * @return bool
     */
    public function updateData($id, $data)
    {
        log_message('debug', 'Updating data for id_cpp=' . $id . ' with data: ' . json_encode($data));
        
        // Update data berdasarkan ID
        $result = $this->where('id', $id)->set($data)->update();
        
        if ($result) {
            log_message('info', 'Data dengan id_cpp=' . $id . ' berhasil diperbarui.');
        } else {
            log_message('warning', 'Data dengan id_cpp=' . $id . ' tidak ditemukan atau tidak ada perubahan.');
        }

        return $result;
    }
}