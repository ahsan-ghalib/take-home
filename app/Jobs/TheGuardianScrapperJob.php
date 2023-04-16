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

class TheGuardianScrapperJob extends BaseScrapperJob
{

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
        $this->url = $url;
    }

    /**
     * Execute the job.
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $totalPages = null;

        while (!$totalPages || $this->query['page'] <= $totalPages) {
            $data = $this->makeHttpsRequest()['response'];

            if ($totalPages === null) {
                $totalPages = ceil($data['total'] / $this->query['pageSize']);
            }

            $this->prepareForInsert($data['results'], $this->query['category']);

            $this->query['page']++;

            // Delay the next request to avoid exceeding the rate limit
            usleep(10000000); // Wait for 500 milliseconds (10 seconds)
        }
    }

    public function prepareForInsert(array $articles, string $category): void
    {
        $articles = collect($articles)->transform(function ($article) use ($category) {
            return [
                'slug' => $article['id'],
                'author' => 'N/A',
                'category' => $article['pillarName'] ?? $category,
                'title' => $article['webTitle'],
                'description' => $article['webTitle'],
                'content' => 'N/A',
                'url' => $article['webUrl'],
                'published_at' => Carbon::parse($article['webPublicationDate']),
                'source' => json_encode(['url' => $article['apiUrl']]),
                'scraped_from' => 'the-guardian-api',
                'created_at' => now(),
                'updated_at' => now(),
            ];

        })->toArray();

        $this->insertArticles($articles);
    }
}
