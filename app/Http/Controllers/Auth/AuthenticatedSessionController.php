<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        return $this->error('User Not Found',404);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
