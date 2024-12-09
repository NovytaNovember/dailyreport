<?php

namespace App\Models;

use CodeIgniter\Model;

class OlcRuntimeModel extends Model
{
    protected $table = 'olc_runtime';
    protected $primaryKey = 'id_olc_runtime';
    protected $allowedFields = [
        'id_cpp',
        'explanation',
        'rate',
        'run_time_from',
        'run_time_to',
        'duration_minutes_runtime',
        'delay_time_from',
        'delay_time_to',
        'duration_minutes_delay',
        'type_delay',
        'total_run_time',
        'total_delay_time',
        'total_type_delayed',
    ];
}