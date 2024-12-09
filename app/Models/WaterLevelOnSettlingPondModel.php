<?php
namespace App\Models;
use CodeIgniter\Model;

class WaterLevelOnSettlingPondModel extends Model
{
    protected $table = 'water_level_on_settling_pond';
    protected $primaryKey = 'id_water_level_on_settling_pond';
    protected $allowedFields = [
        'id_cpp', 
        'based_akhir_shift', 
        'based_awal_shift', 
        'total_consumption', 
        'use_of_water_awal_shift', 
        'use_of_water_akhir_shift', 
        'consumption', 
        'tanggal'
    ];

    // Optional: You can add validation rules here if needed
    protected $validationRules = [
        'id_cpp' => 'required|integer',
        'based_akhir_shift' => 'required|decimal',  // Periksa apakah decimal dengan presisi cukup
        'based_awal_shift' => 'required|decimal',
        'total_consumption' => 'required|decimal',
        'use_of_water_awal_shift' => 'required|decimal',
        'use_of_water_akhir_shift' => 'required|decimal',
        'consumption' => 'required|decimal',
        'tanggal' => 'required|valid_date[Y-m-d]',  // Pastikan format tanggal sesuai (Y-m-d)
    ];

    // Optional: You can also add custom validation error messages here
    protected $validationMessages = [
        'id_cpp' => [
            'required' => 'ID CPP harus diisi.',
            'integer' => 'ID CPP harus berupa angka bulat.',
        ],
        'tanggal' => [
            'valid_date' => 'Tanggal tidak valid. Gunakan format YYYY-MM-DD.',
        ],
    ];

    // You can add additional methods for custom queries here
}