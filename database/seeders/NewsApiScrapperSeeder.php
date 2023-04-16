<?php

namespace Database\Seeders;

use App\Services\NewsApiScrapperService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;

class NewsApiScrapperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws GuzzleException
     */
    public function run(): void
    {
        (new NewsApiScrapperService([
            'pageSize' => 100,
            'page' => 1,
        ]))->execute();
    }
}
