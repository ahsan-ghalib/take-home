<?php

namespace App\Jobs;

use App\Enums\SourceEnum;
use App\Models\News;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsApiScrapperJob extends BaseScrapperJob
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
        $this->url = $url . 'top-headlines';
    }

    public function handle(): void
    {
        $totalPages = null;

        while (!$totalPages || $this->query['page'] <= $totalPages) {
            $data = $this->makeHttpsRequest();

            if ($totalPages === null) {
                $totalPages = ceil($data['totalResults'] / $this->query['pageSize']);
            }

            $this->prepareForInsert($data['articles'], $this->query['category']);

            $this->query['page']++;

            // Delay the next request to avoid exceeding the rate limit
            usleep(10000000); // Wait for 500 milliseconds (10 seconds)
        }
    }

    public function prepareForInsert(array $articles, string $category)
    {
        $articles = collect($articles)->transform(function ($article) use ($category) {
            $slug = mb_strtolower($category) . '/' . Carbon::parse($article["publishedAt"])->format("Y/M/d") . '/' . str_replace(" ", "-", $article["title"]);

            return [
                'slug' => $slug,
                'author' => $article['author'],
                'category' => $category,
                'title' => $article['title'],
                'description' => $article['description'] ?? 'N/A',
                'content' => $article['content'] ?? 'N/A',
                'url' => $article['url'],
                'url_to_image' => $article['urlToImage'],
                'published_at' => Carbon::parse($article['publishedAt']),
                'source' => json_encode($article['source']),
                'scraped_from' => SourceEnum::News_Api->value,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        $this->insertArticles($articles);
    }
}
