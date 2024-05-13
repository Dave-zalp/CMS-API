<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends Controller
{
    use HttpResponse;
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($user){
            $token = $user->createToken($request->userAgent())->plainTextToken;

            return $this->success([
                'user' => $user,
                'token' => $token
            ],'User Created',Response::HTTP_CREATED);
        }
            return $this->error('User Not Created', Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
