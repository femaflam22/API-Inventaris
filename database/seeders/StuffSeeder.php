<?php

namespace Database\Seeders;

use App\Models\Stuff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StuffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stuff::factory()->count(5)->create();
    }
}
