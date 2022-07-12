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
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="loginUser",
     *      tags={"User"},
     *      security={{ "apiAuth": {} }},
     *      summary="Authenticate user",
     *      description="Authenticate user",
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="bolean", example="mailer@gmail2.com"),
     *              @OA\Property(property="password", type="bolean", example="12345678")
     *              
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="bolean", example="true"),
     *              @OA\Property(property="message", type="bolean", example="Login successful"),
     *              @OA\Property(
     *                  type="object",
     *                  property="data",
     *                       @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="4"
     *                      ),
     *                       @OA\Property(
     *                         property="first_name",
     *                         type="string",
     *                         example="Olamilekan"
     *                      ),
     *                      @OA\Property(
     *                         property="last_name",
     *                         type="string",
     *                         example="Adeniyi"
     *                      ),
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="mailer@gmail2.com"
     *                      ),
     *                      @OA\Property(
     *                         property="user_type",
     *                         type="string",
     *                         example="user"
     *                      ),
    *                        @OA\Property(
    *                         property="email_verified_at",
    *                         type="null",
    *                         example="null"
    *                          ),
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      ),
     *                      @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      )
     *                      
     *              ),
     *               @OA\Property(
*                         property="token",
*                         type="string",
*                         example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vcmV0YWlsLWFwcC50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjU3NjA5NjMwLCJleHAiOjE2NTc2MTMyMzAsIm5iZiI6MTY1NzYwOTYzMCwianRpIjoiZ1E3ZUNGMjZRamJ2VEVqUiIsInN1YiI6IjQiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.IcfCIE-Nopl-IOzK3aIABa-WYZVtt991S3LUsGxSpIw"
     *                ),
     *              
     *          )
     *       ),
     *        @OA\Response(
     *          response=500,
     *          description="Internal server error."
     *       ),
     *         @OA\Response(
     *          response=405,
     *          description="Bad method."
     *       )
     *     )
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response([
                'status' => false,
                'message' => trans('auth.failed'),
                'data' => null
            ],405);
        }
        return response()->json([
            'status' =>true,
            'message' =>trans('auth.login'),
            'data' => auth()->user(),
            'token' => $token
        ]);
        // return $this->respondWithToken($token);
    }

     /**
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="registerUser",
     *      tags={"User"},
     *      security={{ "apiAuth": {} }},
     *      summary="Register auth",
     *      description="Register auth",
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="first_name", type="string", example="Cabana"),
     *              @OA\Property(property="last_name", type="string", example="Copa"),
     *              @OA\Property(property="email", type="bolean", example="mailer@gmail22.com"),
     *              @OA\Property(property="password", type="bolean", example="12345678")
     *              
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="bolean", example="true"),
     *              @OA\Property(property="message", type="bolean", example="Registration successful"),
     *              @OA\Property(
     *                  type="object",
     *                  property="data",
     *                       @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="4"
     *                      ),
     *                       @OA\Property(
     *                         property="first_name",
     *                         type="string",
     *                         example="Cabana"
     *                      ),
     *                      @OA\Property(
     *                         property="last_name",
     *                         type="string",
     *                         example="Copa"
     *                      ),
     *                      @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="mailer@gmail22.com"
     *                      ),
     *                      @OA\Property(
     *                         property="user_type",
     *                         type="string",
     *                         example="user"
     *                      ),
    *                        @OA\Property(
    *                         property="email_verified_at",
    *                         type="null",
    *                         example="null"
    *                          ),
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      ),
     *                      @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      )
     *                      
     *              ),
     *               @OA\Property(
*                         property="token",
*                         type="string",
*                         example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vcmV0YWlsLWFwcC50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNjU3NjA5NjMwLCJleHAiOjE2NTc2MTMyMzAsIm5iZiI6MTY1NzYwOTYzMCwianRpIjoiZ1E3ZUNGMjZRamJ2VEVqUiIsInN1YiI6IjQiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.IcfCIE-Nopl-IOzK3aIABa-WYZVtt991S3LUsGxSpIw"
     *                ),
     *              
     *          )
     *       ),
     *        @OA\Response(
     *          response=500,
     *          description="Internal server error."
     *       ),
     *         @OA\Response(
     *          response=401,
     *          description="Bad method."
     *       )
     *     )
     */

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