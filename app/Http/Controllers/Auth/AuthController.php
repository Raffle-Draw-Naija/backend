<?php

namespace App\Http\Controllers\Auth;

use App\Models\NewCustomer;
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
    public function registerUser(UserRequest $userRequest, Utils $utils)
    {

        $identity = Str::random(50);
        $user = new User;
        $user->username = $userRequest->get("username");
        $user->password = Hash::make($userRequest->get("password"));
        $user->identity = $identity;
        $user->verified = 0;
        $user->save();

        $customer = new NewCustomer;
        $customer->first_name =  $userRequest->get("first_name");
        $customer->last_name  = $userRequest->get("last_name");
        $customer->phone = $userRequest->get("phone");
        $customer->user_id = $user->id;
        $customer->save();

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
