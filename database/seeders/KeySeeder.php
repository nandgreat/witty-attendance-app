<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['key_name' => 'CCU Key', 'key_status' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['key_name' => 'Child Care Key', 'key_status' => 0, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('keys')->insert($default);
    }
}
