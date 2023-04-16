<?php

namespace App\Services;

use App\Enums\NewsApiCategoryEnum;
use App\Jobs\NewsApiScrapperJob;
use App\Jobs\NyTimesScrapperJob;
use App\Jobs\TheGuardianScrapperJob;
use GuzzleHttp\Exception\GuzzleException;

class NyTimesScrapperService
{
    /**
     * @throws GuzzleException
     */
    public function execute()
    {
        $currentPage = 0;
        $pageSize = 10;

        $theGuardianApi = config('app.ny_times_api');

        NyTimesScrapperJob::dispatch([
            'category' => '',
            'api-key' => $theGuardianApi['key'],
            'pageSize' => $pageSize,
            'page' => $currentPage
        ], $theGuardianApi['url']);

    }
}
