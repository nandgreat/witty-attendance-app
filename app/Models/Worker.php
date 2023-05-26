<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'worker_code',
        'email',
        'department_id',
        'image_url'
    ];


    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
