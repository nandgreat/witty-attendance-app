<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default = [
            ['event_name' => '7DG Day 1 (Evening)', 'start_time' => Carbon::now()->setDate(2023, 7, 1)->setTime(17, 30, 0)->toDateTimeString(), 'can_clock_in' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('events')->insert($default);
    }
}
