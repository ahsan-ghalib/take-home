<?php

namespace App\Services;

use App\Enums\NewsApiCategoryEnum;
use App\Jobs\NewsApiScrapperJob;
use GuzzleHttp\Exception\GuzzleException;

class NewsApiScrapperService
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
        $newsApi = config('app.news_api');

        foreach (NewsApiCategoryEnum::array() as $category) {
            NewsApiScrapperJob::dispatch(array_merge($this->query, [
                'category' => $category,
                'apiKey' => $newsApi['key']
            ]), $newsApi['url']);
        }
    }
}
