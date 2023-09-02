<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/user/register",
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="first_name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="last_name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="phone",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Registration successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function registerUser(UserRequest $userRequest, Utils $utils): JsonResponse
    {

        $identity = Str::random(50);
        $userRequest->request->add(["password" => Hash::make($userRequest->get("password"))]);
        $user = User::create(array_merge($userRequest->all(), ['identity' => $identity, 'verified' => 1]));
        return $utils->message("success", $user, 200);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/admin/login",
     *     summary="Authenticate user and generate Sactum token",
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="Username",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function login(LoginRequest $loginRequest, Utils $utils)
    {

        if (!auth()->attempt(request()->only(['username', 'password']))) {
            return $utils->message( "error", "Invalid Username/Password", ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $authUser = Auth::user();
        $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
        $success['first_name'] =  $authUser->first_name;
        $success['last_name'] =  $authUser->last_name;
        $success['username'] =  $authUser->username;
        return $utils->message("success", $success, 200);

    }
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
