<?php

namespace Database\Seeders;

use App\Services\NewsApiScrapperService;
use Illuminate\Database\Seeder;

class NewsApiScrapperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new NewsApiScrapperService())->execute();
    }
}
