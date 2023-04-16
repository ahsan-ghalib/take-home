<?php

namespace App\Services;

use App\Enums\NewsApiCategoryEnum;
use App\Jobs\NewsApiScrapperJob;
use App\Jobs\TheGuardianScrapperJob;
use GuzzleHttp\Exception\GuzzleException;

class TheGuardianScrapperService
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
        $theGuardianApi = config('app.the_guardian_api');

        TheGuardianScrapperJob::dispatch(array_merge($this->query, [
            'category' => '',
            'api-key' => $theGuardianApi['key'],
        ]), $theGuardianApi['url']);

    }
}
