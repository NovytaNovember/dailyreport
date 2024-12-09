<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductionTodayModel extends Model
{
    protected $table = 'production_today';
    protected $primaryKey = 'id_production_today';
    protected $allowedFields = ['id_cpp', 'production_today', 'awal', 'akhir', 'total', 'tanggal'];

    public function getByCppId($id_cpp)
    {
        return $this->where('id_cpp', $id_cpp)->findAll();
    }

    public function deleteByProductionToday($productionToday)
    {
        return $this->where('production_today', $productionToday)->delete();
    }
}