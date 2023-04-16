<?php

namespace App\Console\Commands;

use App\Services\NyTimesScrapperService;
use Illuminate\Console\Command;

class NyTimesScrapperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hourly:ny-times-scrapper-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap news in every hour from new york times api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new NyTimesScrapperService([
            'pageSize' => 0,
            'page' => 10,
            'begin_date' => now()->subHour()->startOfHour(),
            'end_date' => now()->subHour()->endOfHour(),
        ]))->execute();
    }
}
