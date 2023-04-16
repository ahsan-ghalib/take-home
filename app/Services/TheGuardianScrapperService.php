<?php

namespace App\Services;

use App\Enums\NewsApiCategoryEnum;
use App\Jobs\NewsApiScrapperJob;
use App\Jobs\TheGuardianScrapperJob;
use GuzzleHttp\Exception\GuzzleException;

class TheGuardianScrapperService
{
    /**
     * @throws GuzzleException
     */
    public function execute()
    {
        $currentPage = 1;
        $pageSize = 100;

        $theGuardianApi = config('app.the_guardian_api');

        TheGuardianScrapperJob::dispatch([
            'category' => '',
            'api-key' => $theGuardianApi['key'],
            'pageSize' => $pageSize,
            'page' => $currentPage
        ], $theGuardianApi['url']);

    }
}
