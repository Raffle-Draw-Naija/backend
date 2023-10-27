<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/admin/categories",
     *     summary="Get all Categories",
     *     tags={"Admin"},
     *     @OA\Response(response="200", description="Get all Categories"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function index()
    {
        // the is the part that is listing all the categories
        $Categories = Categories::all();
        return response()->json(['Categories'=>$Categories], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/category/create",
     *     summary="Create New Categories",
     *     tags={"Admin"},
     *     @OA\Response(response="200", description="Create New Categories"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function store(Request $request, Utils $utils)
    {
        $request->validate([
            "name" => "required"
        ]);
        $category =  Categories::create($request->all());
        return  $utils->message("success", $category, 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categories $categories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        //
    }
}
