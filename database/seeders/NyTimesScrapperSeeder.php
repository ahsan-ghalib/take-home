<?php

namespace Database\Seeders;

use App\Services\NyTimesScrapperService;
use Illuminate\Database\Seeder;

class NyTimesScrapperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new NyTimesScrapperService())->execute();
    }
}
