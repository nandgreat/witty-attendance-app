<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'worker_id',
        'key_id',
        'time_in',
        'time_out',
    ];
}
