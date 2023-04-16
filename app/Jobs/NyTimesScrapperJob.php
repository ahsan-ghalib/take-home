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

class NyTimesScrapperJob extends BaseScrapperJob
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

    public function handle(): void
    {
        $totalPages = null;

        while (!$totalPages || $this->query['page'] <= $totalPages) {
            $data = $this->makeHttpsRequest()['response'];

            if ($totalPages === null) {
                $totalPages = ceil($data['meta']['hits'] / $this->query['pageSize']);
            }

            $this->prepareForInsert($data['docs'], $this->query['category']);

            $this->query['page']++;

            // Delay the next request to avoid exceeding the rate limit
            usleep(10000000); // Wait for 500 milliseconds (10 seconds)
        }
    }

    public function prepareForInsert(array $articles, string $category): void
    {
        $articles = collect($articles)->transform(function ($article) use ($category) {
            $slug = mb_strtolower(str_replace(' ', '-', $article['type_of_material'])) . '/'. Carbon::parse($article['pub_date'])->format('Y/M/d') .'/'. str_replace(' ', '-', $article['headline']['main']);

            return [
                'slug' => $slug,
                'author' => $article['byline']['original'],
                'category' => $article['type_of_material'] ?? $category,
                'title' => $article['headline']['main'],
                'description' => $article['abstract'],
                'content' => $article['lead_paragraph'],
                'url' => $article['web_url'],
                'published_at' => Carbon::parse($article['pub_date']),
                'source' => json_encode($article['multimedia']),
                'scraped_from' => 'nyt-api',
                'created_at' => now(),
                'updated_at' => now(),
            ];

        })->toArray();

        $this->insertArticles($articles);
    }
}
