<?php

namespace App\Http\Controllers\Auth;

use App\Execs\Execs;
use App\Http\Resources\StatesResource;
use App\Http\Resources\UserResource;
use App\Mail\PasswordCodeEmail;
use App\Mail\VerifyCodeMail;
use App\Models\Agent;
use App\Models\Keys;
use App\Models\NewCustomer;
use App\Models\Notifications;
use App\Models\Stake;
use App\Models\States;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
     * @OA\Get  (
     *     path="/api/v1/get-flw-pub-key",
     *      tags={"General"},
     *     @OA\Response(response="200", description="Pin Validate successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getFlwPubKey( Utils $utils)
    {

        return $utils->message("success", Keys::where("id", 1)->get(), 200);

    }

    /**
     * @OA\Get  (
     *     path="/api/v1/get-flw-sec-key",
     *      tags={"General"},
     *     @OA\Response(response="200", description="Pin Validate successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getFlwSecKey( Utils $utils)
    {

        return $utils->message("success", Keys::where("id", 2)->get(), 200);

    }
    /**
     * @OA\Get  (
     *     path="/api/v1/get-flw-enc-key",
     *      tags={"General"},
     *     @OA\Response(response="200", description="Pin Validate successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getFlwEncKey( Utils $utils)
    {

        return $utils->message("success", Keys::where("id", 3)->get(), 200);

    }
    /**
     * @OA\Post (
     *     path="/api/v1/validate-pin",
     *      tags={"General"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="user_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="pin",
     *         in="query",
     *         description="pin",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Pin Validate successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function validatePin(Request $request, Utils $utils)
    {
        $request->validate([
            "user_id" => "required|int",
            "pin" => "required|digits:6"
        ]);

        if (!User::where("id", $request->get("user_id"))->exists())
            return $utils->message("error", "User Not Found", 404);

        $pinFromDB = User::where("id", $request->get("user_id"))->value("pin");
        if (!$utils->validatePin($request, $pinFromDB, $utils))
            return   $utils->message("error", "Invalid Pin", 401);

        return $utils->message("success", "Pin Validated Successfully.", 200);

    }
    /**
     * @OA\Patch(
     *     path="/api/v1/create-pin",
     *      tags={"General"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="user_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="pin",
     *         in="query",
     *         description="pin",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Pin Created successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function createPin(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
           "user_id" => "required|int",
           "pin" => "required|int|digits:6"
        ]);

        if (!User::where("id", $request->get("user_id"))->exists())
            return $utils->message("error", "User Not Found", 404);

        $user = User::find($request->get("user_id"));
        $user->pin = Hash::make($request->get("pin"));
        $user->update();
        return $utils->message("success", "Pin Updated Successfully.", 200);

    }
    public function getStates(Utils $utils)
    {
        return $utils->message("success", StatesResource::collection(States::all()), 200);
    }

    public function registerCustomer(UserRequest $userRequest, Utils $utils, Execs $execs)
    {

        try{

            $user =  $execs->createUser($userRequest, $utils, "customer");
            $customer = $execs->createCustomer($userRequest, $user,  $utils);
            $data = [
                "user" => New UserResource($user),
                "customer" => $customer
            ];
            return $utils->message("success", $data, 200);
        }catch (\Throwable $e) {
            Log::error("########## " . $e->getMessage() . " #########");
            return $utils->message("error", $e->getMessage(), 404);
        }
    }
    public function registerAgent(UserRequest $userRequest, Utils $utils, Execs $execs)
    {
        try{

            $user =  $execs->createUser($userRequest, $utils);
            $agent = $execs->createAgent($user->id,  $userRequest, $utils);
            $data = [
                "user" => New UserResource($user),
                "agent" => $agent
            ];
//        Mail::mailer("no-reply")->to($userRequest->get("email"))->send(new VerifyCodeMail($mailData));
            return $utils->message("success", $data, 200);
        }catch (\Throwable $e) {
            Log::error("########## " . $e->getMessage() . " #########");
            return $utils->message("error", $e->getMessage(), 404);
        }
    }
    public function sendNotification(Request $request, Utils $utils)
    {
        $response =  $utils->sendNotifications($request);
        return  $utils->message("success", $response, 200);
    }


    /**
     * @OA\Get (
     *     path="/api/v1/customer/get-notifications",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="user_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Registration successful", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     *
     *     */
    public function getNotification(Request $request, Utils $utils)
    {
        $request->validate([
            "user_id" => "required"
        ]);
        $notifications = Notifications::where("user_id", $request->get("user_id"))->with(["customerStake", "customers"])->get();
        return  $utils->message("success", $notifications, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/customer/register-user",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
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
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="device_id",
     *         in="query",
     *         description="device_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Registration successful", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function registerUser(UserRequest $userRequest, Utils $utils)
    {
        $identity = Str::random(50);
        $verify_code = random_int(100000, 999999);
        $user = new User;
        $user->username = $userRequest->get("username");
        $user->password = Hash::make($userRequest->get("password"));
        $user->identity = $identity;
        $user->verified = 0;
        $user->email = $userRequest->get("email");
        $user->verify_code = $verify_code;
        $user->device_id = $userRequest->get("device_id");
        $user->save();

        $customer = new NewCustomer;
        $customer->first_name =  $userRequest->get("first_name");
        $customer->last_name  = $userRequest->get("last_name");
        $customer->phone = $userRequest->get("phone");
        $customer->user_id = $user->id;
        $customer->save();

        $mailData = [
            'title' => 'Verification Code',
            'code' => $verify_code
        ];
        Mail::mailer("no-reply")->to($userRequest->get("email"))->send(new VerifyCodeMail($mailData));
        return $utils->message("success", $user, 200);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/customer/verify-code",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="username",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="code",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Verification successful",  @OA\JsonContent()),
     *     @OA\Response(response="404", description="Code Not Found",  @OA\JsonContent()),
     *     @OA\Response(response="500", description="Internal Server Error",  @OA\JsonContent())
     * )
     */
    public function verifyCode(Request $request, Utils $utils)
    {

        $request->validate([
            "code" => "required|string",
            "username" => "required|string"
        ]);

        if(!User::where("username", $request->get("username"))->where("verify_code", $request->get("code"))->exists())
            return $utils->message("error", "Invalid Code", 404);

        if($request->get("code") == 0)
            return $utils->message("error", "Invalid Code", 422);

        $user = User::where("username", $request->get("username"))->firstOrFail();
        $user->verified = 1;
        $user->verify_code = 0;
        $user->update();
        return $utils->message("success","Verification Successful.", 200);

    }
    /**
     * @OA\Post(
     *     path="/api/v1/customer/forgot-password",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Registration successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function forgotPassword(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "email" => "required|string"
        ]);
        $email = $request->get("email");
        if (!User::where("email", $email)->exists())
            return $utils->message("error", "User Not Found", 404);
        $password_reset_code = random_int(100000, 999999);
        User::where("email", $email)->update(["password_reset" => $password_reset_code]);
        $mailData = [
            'title' => 'Reset your password',
            'code' => $password_reset_code
        ];
        Mail::mailer("no-reply")->to($email)->send(new PasswordCodeEmail($mailData));
        return $utils->message("success", $mailData, 200);

    }
    /**
     * @OA\Post(
     *     path="/api/v1/customer/update/password",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="new_password",
     *         in="query",
     *         description="new_password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="confirm_password",
     *         in="query",
     *         description="confirm_password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Registration successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function updatePassword(Request $request, Utils $utils)
    {
        $request->validate([
            "email" => "required|string",
            'new_password' => "required|string|required_with:confirm_password|same:confirm_password",
            'confirm_password' => "required|string"
        ]);

        if(!User::where('email',$request->get("email"))->exists())
            return $utils->message("error", "User Not Found", 404);


        User::where("email", $request->get("email"))->update(["password" => Hash::make($request->get("new_password"))]);
        return $utils->message("success", "Password Updated Successfully.", 200);

    }


    /**
     * @OA\Post(
     *     path="/api/v1/customer/verify-otp",
     *     summary="Authenticate user and generate Sactum token",
     *     tags={"General"},
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="code",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Verification successful", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Validation Error", @OA\JsonContent())
     *
     * )
     */
    public function verifyOTP(Request $request, Utils $utils)
    {
        $request->validate([
            'code' => "required|integer",
        ]);
        if(User::where('email',$request->get("email"))->value("password_reset") !== $request->get("code"))
            return $utils->message("error", "Code is incorrect", 401);

        return $utils->message("success", "Code Verified Successfully.", 200);


    }
    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Authenticate user and generate Sactum token",
     *     tags={"General"},
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
     *     @OA\Parameter(
     *         name="device_id",
     *         in="query",
     *         description="Device ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Unauthorized", @OA\JsonContent()),
     *     @OA\Response(response="422", description="Validation Error", @OA\JsonContent())
     * )
     */
    public function login(LoginRequest $loginRequest, Utils $utils)
    {

        if (!auth()->attempt(request()->only(['username', 'password']))) {
            return $utils->message( "error", "Invalid Username/Password", 401);
        }

        if (Auth::user()->role=="Agent")
            $user = Agent::where("user_id", Auth::user()->id)->firstOrFail();
        else
            $user = NewCustomer::where("user_id", Auth::user()->id)->firstOrFail();

        $loginRequest->get("device_id");
        $authUser = Auth::user();
        $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
        $success['first_name'] =   $user->first_name;
        $success['last_name'] =  $user->last_name;
        $success['username'] =  $authUser->username;
        $success['email'] =  $authUser->email;
        $success['phone'] =  $user->phone;
        $success['id'] =  $authUser->id;
        $success['role'] =  $authUser->role;
        return $utils->message("success", $success, 200);
    }
    public function logout(User $user, Utils $utils): JsonResponse
    {
        auth()->logout();
        $user->tokens()->delete();
        return $utils->message("success", "User successfully signed out", 200);
    }
}
