<?php

namespace App\Models;

use CodeIgniter\Model;

class CppModel extends Model
{
    protected $table = 'cpp_data';
    protected $primaryKey = 'id_cpp';
    protected $allowedFields = ['nama_cpp', 'upload_date', 'actual_upload_time'];

    public function getAllData()
    {
        return $this->orderBy('upload_date', 'ASC')->findAll();
    }

    public function getById($id)
    {
        return $this->find($id);
    }

    public function saveData($data)
    {
        return $this->insert($data, true);
    }

    public function deleteData($id)
    {
        return $this->delete($id);
    }

    public function searchData($keyword = null, $startDate = null, $endDate = null)
    {
        $query = $this->orderBy('upload_date', 'ASC');

        if (!empty($keyword)) {
            $query->like('nama_cpp', $keyword);
        }

        if (!empty($startDate)) {
            $query->where('upload_date >=', $startDate);
        }

        if (!empty($endDate)) {
            $query->where('upload_date <=', $endDate);
        }

        return $query->findAll();
    }
}