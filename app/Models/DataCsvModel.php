<?php

namespace App\Models;

use CodeIgniter\Model;

class DataCsvModel extends Model
{
    protected $table = 'data_csv';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_file','jenis_file','data_file', 'upload_date'];
}