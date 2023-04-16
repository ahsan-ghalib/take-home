<?php

namespace Database\Seeders;

use App\Services\TheGuardianScrapperService;
use Illuminate\Database\Seeder;

class TheGuardianScrapperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new TheGuardianScrapperService())->execute();
    }
}
