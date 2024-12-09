<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyTankCapModel extends Model
{
    protected $table = 'daily_tank_cap';
    protected $primaryKey = 'id_daily_tank_cap';
    protected $allowedFields = [
        'id_cpp',
        'tanggal',
        'awal_shift_based',
        'akhir_shift_based',
        'useoffuel_awal_shift',
        'useoffuel_akhir_shift',
        'flow_meter_outlet_awal_shift',
        'flow_meter_outlet_akhir_shift',
        'total_consumption',
        'consumption',
        'total'
    ];
    
    // Optional: Validation (untuk memastikan data sesuai)
    protected $validationRules = [
        'id_cpp' => 'required|integer',
        'tanggal' => 'required|valid_date',
        'awal_shift_based' => 'required|decimal',
        'akhir_shift_based' => 'required|decimal',
        'useoffuel_awal_shift' => 'required|decimal',
        'useoffuel_akhir_shift' => 'required|decimal',
        'flow_meter_outlet_awal_shift' => 'required|decimal',
        'flow_meter_outlet_akhir_shift' => 'required|decimal',
        'total_consumption' => 'required|decimal',
        'consumption' => 'required|decimal',
        'total' => 'required|decimal'
    ];

    // Optional: Custom error message
    protected $validationMessages = [
        'id_cpp' => ['required' => 'ID CPP is required', 'integer' => 'ID CPP must be an integer'],
        'tanggal' => ['required' => 'Tanggal is required', 'valid_date' => 'Tanggal must be a valid date'],
    ];

    public function updateData($id_daily_tank_cap, $data)
    {
        return $this->update($id_daily_tank_cap, $data);
    }
}