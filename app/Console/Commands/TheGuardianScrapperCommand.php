<?php

namespace App\Console\Commands;

use App\Services\TheGuardianScrapperService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class TheGuardianScrapperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hourly:the-guardian-scrapper-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap news in every hour from the guardian api';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle()
    {
        (new TheGuardianScrapperService([
            'pageSize' => 100,
            'page' => 1,
            'from-date' => now()->subHour()->startOfHour(),
            'to-date' => now()->subHour()->endOfHour(),
        ]))->execute();
    }
}
