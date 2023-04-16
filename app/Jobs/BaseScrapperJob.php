<?php

namespace App\Jobs;

use App\Enums\CategoryEnum;
use App\Models\News;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BaseScrapperJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $query;
    protected string $url;

    /**
     * Create a new job instance.
     * @param array $query
     * @param string $url
     */
    public function __construct(array $query, string $url)
    {
        $this->query = $query;
        $this->url = $url . 'top-headlines';
    }

    public function handle(): void
    {

    }
    public function makeHttpsRequest()
    {
        $client = new Client();
        $response = $client->request('GET', $this->url, [
            'query' => $this->query,
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function insertArticles(array $articles): void
    {
        News::query()
            ->upsert($articles, 'slug', [
                'author',
                'category',
                'title',
                'description',
                'content',
                'url',
                'url_to_image',
                'published_at',
                'source',
            ]);
    }
}
