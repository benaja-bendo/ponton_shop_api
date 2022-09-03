<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\SubCategorieProduct;
use App\Http\Controllers\Controller;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SubCategoriesProducts = SubCategorieProduct::all();

        return response()->json([
            "success" => true,
            "message" => "all sub catégories products",
            'data' => [
                "version" => "1.0",
                "language" => app()->getLocale(),
                "support" => env("APP_SUPPORT")
            ],
            'SubCategoriesProducts' => $SubCategoriesProducts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'categorie_product_id' => 'required'
        ]);

        $SubCategorie = SubCategorieProduct::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "sub catégorie create succssfully",
            'SubCategorie' => $SubCategorie,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $SubCategorie = SubCategorieProduct::FindOrFail($id);

        return $SubCategorie;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $SubCategorie = SubCategorieProduct::FindOrFail($id);
        $SubCategorie->update($request->all());

        return $SubCategorie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SubCategorie = SubCategorieProduct::FindOrFail($id);
        $SubCategorie->destroy($id);

        return response()->json([
            "success" => true,
            "message" => "sub catégorie delete succssfully"
        ], 200);
    }
}
