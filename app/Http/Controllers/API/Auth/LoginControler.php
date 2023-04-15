<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class LoginControler extends Controller
{
    /**
     * Handle the incoming request.
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        if (!Auth::attempt($validatedData)) {
            return response()->json([
                'errors' => [
                    'password' => ['Invalid credentials, please try again.'],
                ]
            ], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $user->token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'message' => 'Successfully logged in',
            'data' => $user
        ], SymfonyResponse::HTTP_OK);
    }
}
