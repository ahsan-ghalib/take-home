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

class NewsApiScrapperJob implements ShouldQueue
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

    /**
     * Execute the job.
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $client = new Client();
        $totalPages = null;

        while (!$totalPages || $this->query['page'] <= $totalPages) {
            $response = $client->request('GET', $this->url, [
                'query' => $this->query,
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if ($totalPages === null) {
                $totalPages = ceil($data['totalResults'] / $this->query['pageSize']);
            }

            $this->insertArticles($data['articles'], $this->query['category']);

            $this->query['page']++;

            // Delay the next request to avoid exceeding the rate limit
            usleep(10000000); // Wait for 500 milliseconds (10 seconds)
        }
    }

    public function insertArticles(array $articles, string $category): void
    {
        $articles = collect($articles)->transform(function ($article) use ($category){
            $slug = mb_strtolower($category) . '/'. Carbon::parse($article["publishedAt"])->format("Y/M/d") .'/'. str_replace(" ", "-", $article["title"]);

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
                'scraped_from' => 'news-api',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

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
