<?php

namespace App\Http\Controllers;

use App\Models\SubCategories;
use App\Models\SubCategory;
use App\Utils\Utils;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Utils $utils)
    {

        $request->validate([
            "name" => "required",
            "category_id" => "required"
        ]);
        $category = SubCategories::create($request->all());
        return $utils->message("success", $category, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategories $subCategory)
    {
        //
        {
            $subcategories = SubCategories::all();
            return response()->json(['subcategories' => $subcategories]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategories $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategories $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategories $subCategory)
    {
        //
    }
}