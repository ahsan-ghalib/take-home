<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::query()
            ->get();

        return response()->json([
            'message' => 'Success fetching news',
            'data' => $news
        ], SymfonyResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return response()->json([
            'message' => 'Success fetching news',
            'data' => $news
        ], SymfonyResponse::HTTP_OK);
    }
}
