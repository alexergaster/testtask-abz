<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            ['id' => 1, 'position' => 'Lawyer'],
            ['id' => 2, 'position' => 'Content manager'],
            ['id' => 3, 'position' => 'Security'],
            ['id' => 4, 'position' => 'Designer'],
        ]);
    }
}
