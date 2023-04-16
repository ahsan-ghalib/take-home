<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserNewsFeedPreferenceRequest;
use App\Http\Requests\UpdateUserNewsFeedPreferenceRequest;
use App\Models\UserNewsFeedPreference;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UserNewsFeedPreferenceController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        return response()->json([
            'message' => 'Success fetching news preferences',
            'data' => auth()->user()
                ->newsFeedPreference,
        ], SymfonyResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateUserNewsFeedPreferenceRequest$request
     * @return JsonResponse
     */
    public function update(UpdateUserNewsFeedPreferenceRequest $request): JsonResponse
    {
        UserNewsFeedPreference::query()
            ->updateOrCreate(['user_id' => auth()->id()],$request->validated());

        return response()->json([
            'message' => 'Success updating news feed preferences',
            'data' => null,
        ], SymfonyResponse::HTTP_OK);
    }
}
