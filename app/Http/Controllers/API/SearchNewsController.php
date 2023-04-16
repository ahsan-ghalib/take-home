<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchNewsRequest;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SearchNewsController extends Controller
{
    /**
     * Handle the incoming request.
     * @param SearchNewsRequest $request
     * @return JsonResponse
     */
    public function __invoke(SearchNewsRequest $request): JsonResponse
    {
        $query = News::query();

        if (isset($request->keyword)) {
            $query->orWhere('title', 'like', '%' . $request->keyword . '%')
                ->orWhereRaw("MATCH(content) AGAINST(? IN BOOLEAN MODE)", array($request->keyword))
                ->orWhereRaw("MATCH(`description`) AGAINST(? IN BOOLEAN MODE)", array($request->keyword));
        }

        if (isset($request->date_from, $request->date_to)) {
            $query->whereBetween('published_at', [$request->date_from, $request->date_to]);
        }

        if (isset($request->category)) {
            $query->where('category', '=', $request->category);
        }

        if (isset($request->source)) {
            $query->where('source', '=', $request->source);
        }

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
