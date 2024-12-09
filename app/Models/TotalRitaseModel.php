<?php

namespace App\Models;

use CodeIgniter\Model;

class TotalRitaseModel extends Model
{
    protected $table = 'total_ritase';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_cpp', 'ritase_type', 'total_ritase', 'tanggal'];

    public function getByCppId($id_cpp)
    {
        return $this->where('id_cpp', $id_cpp)->findAll();
    }
}