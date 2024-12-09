<?php

namespace App\Models;

use CodeIgniter\Model;

class UseOfHeavyVehiclesModel extends Model
{
    protected $table = 'use_of_heavy_vehicles';
    protected $primaryKey = 'id_use';
    protected $allowedFields = ['id_cpp', 'company', 'unit', 'start_hm', 'stop_hm', 'operator', 'total_hm', 'fuel', 'remark', 'tanggal'];

    public function getByCppId($id_cpp)
    {
        return $this->where('id_cpp', $id_cpp)->findAll();
    }
}
