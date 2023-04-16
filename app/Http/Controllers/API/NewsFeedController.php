<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class NewsFeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $newsFeedPreferences = auth()->user()->newsFeedPreference;

        $query = News::query()
            ->whereIn('category', $newsFeedPreferences->category)
            ->orWhereIn('source', $newsFeedPreferences->source)
            ->orWhereIn('source', $newsFeedPreferences->author);

        $news = $query->paginate(20);

        if ($news->total() > 0) {
            return response()->json([
                'message' => 'Success fetching news',
                'data' => $news,
            ], SymfonyResponse::HTTP_OK);
        }

        return response()->json([
            'message' => 'No data to show',
            'data' => null,
        ], SymfonyResponse::HTTP_NOT_FOUND);
    }
}
