<?php

namespace Database\Seeders;

use App\Services\TheGuardianScrapperService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;

class TheGuardianScrapperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws GuzzleException
     */
    public function run(): void
    {
        (new TheGuardianScrapperService([
            'pageSize' => 100,
            'page' => 1,
        ]))->execute();
    }
}
