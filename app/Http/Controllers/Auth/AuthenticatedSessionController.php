<?php

namespace App\Http\Controllers\Auth;

use App\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends Controller
{
    use HttpResponse;
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request):   JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            $token = $user->createToken($request->userAgent())->plainTextToken;

            return $this->success([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ],'User Logged In');

        }
        return $this->error('User Not Found',Response::HTTP_NOT_FOUND);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->user()->currentAccessToken()->delete();

        return $this->success('',[
            'message' => 'User Logged Out'
        ],Response::HTTP_OK);
    }
}
