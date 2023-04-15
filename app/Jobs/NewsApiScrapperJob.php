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
        $this->url = $url;
    }

    /**
     * Execute the job.
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $client = new Client();
        $totalPages = null;
        $articles = [];

        while ($totalPages === null || $this->query['page'] <= $totalPages) {
            $response = $client->request('GET', $this->url . 'top-headlines', [
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
        collect($articles)->transform(function ($article) use ($category){
            $slug = '{$category}/{Carbon::parse($article["publishedAt"])->format("Y/M/d")}/{str_replace(" ", "-", $article["title"])}';
            return [
                'slug' => $slug,
                'author' => $article['author'],
                'category' => $category,
                'title' => $article['title'],
                'description' => $article['description'],
                'content' => $article['content'],
                'url' => $article['url'],
                'url_to_image' => $article['urlToImage'],
                'published_at' => $article['publishedAt'],
                'source' => $article['source'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        News::query()
        ->upsert($articles, 'slug');
    }
}
