<?php

namespace App\Http\Controllers;

use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\NewCustomer;

class NewCustomerController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/customer/update/name",
     *     summary="Get Dashboard Items",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="Id of the User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name of the User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),

     *     @OA\Response(response="200", description="Update user name"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function updateName(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required",
            "name" => "required",
        ]);

        $user = NewCustomer::firstOrFail($request->get("user_id"));
        $user->name = $request->get("name");
        $user->update();
        return  $utils->message("success", "Name Updated Successfully...", 200);

    }
}
