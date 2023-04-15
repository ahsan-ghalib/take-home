<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RegisterControler extends Controller
{
    /**
     * Handle the incoming request.
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = User::query()
            ->create(array_merge($validatedData, ['password' => Hash::make($validatedData['password'])]));

        $user->token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'message' => 'Successfully registered your account',
            'data' => $user,
        ], SymfonyResponse::HTTP_OK);
    }
}
