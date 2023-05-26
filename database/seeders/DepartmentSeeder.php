<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['department_name' => 'Hosts And Hostesses', 'department_short_name' => "H n H", 'no_of_keys' => 3, 'keys_taken' => 0, 'keys_available' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['department_name' => 'Child Care', 'department_short_name' => "Child Card", 'no_of_keys' => 3, 'keys_taken' => 0, 'keys_available' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['department_name' => 'COZA Corporate', 'department_short_name' => "COZA Corporate", 'no_of_keys' => 3, 'keys_taken' => 0, 'keys_available' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['department_name' => 'Direct Secret Service', 'department_short_name' => "DSS", 'no_of_keys' => 3, 'keys_taken' => 0, 'keys_available' => 3,  'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('departments')->insert($default);
    }
}
