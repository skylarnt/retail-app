<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response([
                'status' => false,
                'message' => trans('auth.failed'),
                'data' => null
            ],401);
        }
        return response()->json([
            'status' =>true,
            'message' =>trans('auth.login'),
            'data' => auth()->user(),
            'token' => $token
        ]);
        // return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {
        
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->user_type = 'user';
            $user->password = Hash::make($request->password);
            $user->save();
            
         
            $credentials = request(['email', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return response([
                    'status' => false,
                    'message' => trans('auth.failed'),
                    'data' => null
                ],401);
            }
            
            return response()->json([
                'status' =>true,
                'message' =>trans('auth.register'),
                'data' => auth()->user(),
                'token' => $token
            ]);
         
            
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}