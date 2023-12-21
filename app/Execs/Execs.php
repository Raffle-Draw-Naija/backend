<?php

namespace App\Execs;

use App\Mail\VerifyCodeMail;
use App\Models\Agent;
use App\Models\NewCustomer;
use App\Utils\Utils;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
class Execs
{
    public function createUser($userRequest, $utils, $role)
    {
            return  DB::transaction(function () use ($userRequest, $utils, $role) {
                    $identity = Str::random(50);
                    $verify_code = random_int(100000, 999999);
                    $user = new User;
                    $user->username = $userRequest->get("username");
                    $user->password = Hash::make($userRequest->get("password"));
                    $user->identity = $identity;
                    $user->verified = 0;
                    $user->role = $role;
                    $user->email = $userRequest->get("email");
                    $user->verify_code = $verify_code;
                    $user->device_id = $userRequest->get("device_id");
                    $user->save();
                    $mailData = [
                        'title' => 'Verification Code',
                        'code' => $verify_code
                    ];
                    Mail::mailer("no-reply")->to($userRequest->get("email"))->send(new VerifyCodeMail($mailData));

                    return $user;
            });
    }
    public function createAgent($user_id, $agentRequest, $utils): Agent
    {
        try {

            return  DB::transaction(function () use ($user_id, $agentRequest, $utils) {
                try {
                    $agent = new Agent;
                    $agent->first_name =  $agentRequest->get("first_name");
                    $agent->last_name  = $agentRequest->get("last_name");
                    $agent->phone = $agentRequest->get("phone");
                    $agent->address = $agentRequest->get("address");
                    $agent->user_id = $user_id;
                    $agent->save();
                    return $agent;
                } catch (\Throwable $e) {
                    Log::error("########## " . $e->getMessage() . " #########");
                    return $utils->message("error", $e->getMessage(), 404);
                }
            });
        } catch(ValidationException $e){
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return $utils->message("error", $e->getMessage(), 422);
        } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }

    }

    public function createCustomer($userRequest, $user, $utils)
    {

        try {

            return  DB::transaction(function () use ($userRequest, $user, $utils) {
                try {
                    $customer = new NewCustomer;
                    $customer->first_name =  $userRequest->get("first_name");
                    $customer->last_name  = $userRequest->get("last_name");
                    $customer->phone = $userRequest->get("phone");
                    $customer->user_id = $user->id;
                    $customer->save();
                    return $customer;
                } catch (\Throwable $e) {
                    Log::error("########## " . $e->getMessage() . " #########");
                    return $utils->message("error", $e->getMessage(), 404);
                }
            });
        } catch(ValidationException $e){
            // Rollback and then redirect
            // back to form with errors
            DB::rollback();
            return $utils->message("error", $e->getMessage(), 422);
        } catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
    }
}
