<?php

namespace App\Services;

use App\Enums\NewsApiCategoryEnum;
use App\Jobs\NewsApiScrapperJob;
use App\Jobs\NyTimesScrapperJob;
use App\Jobs\TheGuardianScrapperJob;
use GuzzleHttp\Exception\GuzzleException;

class NyTimesScrapperService
{
    protected array $query;
    public function __construct(array $query)
    {
        $this->query = $query;
    }

    /**
     * @throws GuzzleException
     */
    public function execute()
    {
        $theGuardianApi = config('app.ny_times_api');

        NyTimesScrapperJob::dispatch(array_merge($this->query, [
            'category' => '',
            'api-key' => $theGuardianApi['key'],
        ]), $theGuardianApi['url']);

    }
}
