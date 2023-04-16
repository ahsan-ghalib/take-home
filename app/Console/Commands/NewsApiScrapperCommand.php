<?php

namespace App\Console\Commands;

use App\Services\NewsApiScrapperService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class NewsApiScrapperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hourly:news-api-scrapper-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap news in every hour from news api';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle()
    {
        (new NewsApiScrapperService([
            'pageSize' => 100,
            'page' => 1,
            'date_from' => now()->subHour()->startOfHour(),
            'date_to' => now()->subHour()->endOfHour(), 
        ]))->execute();
    }
}
