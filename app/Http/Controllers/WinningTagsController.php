<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\WinningTags;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WinningTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/winning-tags/create",
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
        $utils->uploadImage($res["imageName"], $res["image"]);
        $category =  WinningTags::create($request->all());
        return  $utils->message("success", $category, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(WinningTags $winningTags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WinningTags $winningTags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WinningTags $winningTags)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WinningTags $winningTags)
    {
        //
    }
}
