<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'worker_id',
        'time_in'
    ];
}
