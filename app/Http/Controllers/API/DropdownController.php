<?php

namespace App\Http\Controllers\API;

use App\Enums\CategoryEnum;
use App\Enums\SourceEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class DropdownController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            'message' => 'Success fetching dropdowns',
            'data' => [
                'categories' => CategoryEnum::values(),
                'sources' => SourceEnum::values(),
            ]
        ], SymfonyResponse::HTTP_OK);
    }
}
