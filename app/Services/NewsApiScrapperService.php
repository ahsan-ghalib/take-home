<?php

namespace App\Services;

use App\Enums\NewsApiCategoryEnum;
use App\Jobs\NewsApiScrapperJob;
use GuzzleHttp\Exception\GuzzleException;

class NewsApiScrapperService
{
    /**
     * @throws GuzzleException
     */
    public function execute()
    {
        $currentPage = 1;
        $pageSize = 100;

        $newsApi = config('app.news_api');

        foreach (NewsApiCategoryEnum::array() as $category) {
            NewsApiScrapperJob::dispatch([
                'category' => $category,
                'apiKey' => $newsApi['key'],
                'pageSize' => $pageSize,
                'page' => $currentPage
            ], $newsApi['url']);
        }
    }
}
