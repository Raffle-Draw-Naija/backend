<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\RaffleDrawsResource;
use App\Http\Resources\StakeAgentPlatform;
use App\Http\Resources\StakeAgentPlatformResource;
use App\Http\Resources\StakeResource;
use App\Http\Resources\WinningTageResource;
use App\Http\Resources\WinningTageResources;
use App\Http\Resources\WinningTagsCollection;
use App\Models\Notifications;
use App\Models\Stake;
use App\Models\StakePlatform;
use App\Utils\Utils;
use App\Models\Categories;
use App\Models\WinningTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WinningTagsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/get-machines",
     *     summary="Get Machines",
     *     tags={"General"},
     *     @OA\Response(response="200", description="Get Machines"),
     * )
     */
    public function getMachines(Utils $utils)
    {

        $winningTags = WinningTags::where("sub_cat_id", 2)->get();
        return $utils->message("Success", $winningTags, 200);
    }


    public function stopDraw(Request $request, Utils $utils)
    {

         $request->validate([
            "stake_platform_id" => "required"
         ]);
         $stake_platform_id = $request->get("stake_platform_id");
         Stake::where("stake_platform_id", $stake_platform_id)->update(["active" => 0]);

         $stake_platform = StakePlatform::findOrFail($stake_platform_id);
         $stake_platform->is_close = 1;
         $stake_platform->is_open = 0;
         $stake_platform->update();
        Notifications::create([
            "title" => "New Notification",
            "body" => "Raffle has been Drawn",
            "viewed" => "No"
        ]);
        $data = RaffleDrawsResource::collection(StakePlatform::with(["categories", "winningTags"])->orderBy("created_at", "DESC")->get());
        return $utils->message("success", $data, 200);

    }
    /**
     * @OA\Get(
     *     path="/api/v1/category/winning-tags",
     *     summary="Get Machines",
     *     tags={"General"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="category id of the winning tag",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function getTag(Request $request, Utils $utils)
    {
        $request->validate([
            "category_id" => 'required'
        ]);
        $winningTags = WinningTags::where("category_id", $request->get("category_id"))->get();
        return $utils->message("Success", $winningTags, 200);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/admin/winning-tags",
     *     summary="Get Machines",
     *     tags={"General"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="category id of the winning tag",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function adminGetTags($id, Utils $utils)
    {
        $winningTags = WinningTags::where("category_id",$id)->get();
        return $utils->message("Success", $winningTags, 200);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/agent/winning-tags",
     *     summary="Get Machines",
     *     tags={"General"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="category id of the winning tag",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function agentGetTags(Utils $utils)
    {
        $winningTags = WinningTags::all();
        return $utils->message("Success", $winningTags, 200);
    }


    public function getRafflesWithId($id, Utils $utils)
    {

        $stakes = StakePlatform::where("winning_tags_id", $id)->with(["winningTags","categories"])->get();
        return $utils->message("success", StakeAgentPlatformResource::collection($stakes), 200);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/category/winning-tags/:id",
     *     summary="Get a Single Tag",
     *     tags={"General"},
     *     @OA\Response(response="200", description="Get Machines"),
     * )
     */
    public function getSingleTag($id, Utils $utils)
    {

        $winningTags = WinningTags::findOrFail($id);
        return $utils->message("Success", $winningTags, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/get-tools",
     *     summary="Get Tools",
     *     tags={"General"},
     *     @OA\Response(response="200", description="Get Tools"),
     * )
     */
    public function getTools(Utils $utils)
    {

        $winningTags = WinningTags::where("sub_cat_id", 1)->get();
        return $utils->message("Success", $winningTags, 200);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/winning-tags",
     *     summary="Get all winning tags",
     *     tags={"General"},
     *     @OA\Response(response="200", description="Get all winning tags"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function index(Utils $utils)
    {
        $winningTags = WinningTags::with('categories')->get();
        return $utils->message("Success", $winningTags, 200);
    }



    /**
     * @OA\Post(
     *     path="/api/v1/admin/winning-tags/create",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name of the winning tag",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="category_id: 1 = Riders, 2 = Machines, 3 = Tools ",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="stake_price",
     *         in="query",
     *         description="stake_price",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="image",
     *         in="query",
     *         description="image must be in base64",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Registration successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */

    public function store(Request $request, Utils $utils)
    {

        $request->validate([
            "name" => "required",
            "category_id" => "required",
            "sub_cat_id" => "required",
            "stake_price" => "required",
            "image" => "required"
        ]);
        $res = $utils->convertImageToBase64($request, $request->get("image"));
        $img_link = $utils->uploadImage($res["imageName"], $res["image"]);
        $request->request->add(["image" => $img_link]);

        $category = WinningTags::create($request->all());
        return $utils->message("success", $category, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utils $utils)
    {

        $request->validate([
            "winning_tags_id" => "required"
        ]);
        $winningTag = WinningTags::findOrFail($request->get("winning_tags_id"));
        $winningTag->name = $request->get("name");
        $winningTag->stake_price = $request->get("stake_price");
        $winningTag->update();
        return $utils->message("success", $winningTag, 200);

    }

}
