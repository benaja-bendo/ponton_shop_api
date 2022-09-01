<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\CategorieProduct;
use Illuminate\Http\Request;

class CategoriesProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categoriesProducts = CategorieProduct::all();

        return response()->json([
            "success" => true,
            "message" => "all catégories products",
            'data' => [
                "version" => "1.0",
                "language" => app()->getLocale(),
                "support" => env("APP_SUPPORT")
            ],
            'catégories-products' => $categoriesProducts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name'=>'required',
        ]);

        $CategorieProduct = CategorieProduct::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "catégorie create succssfully",
            'CategorieProduct' => $CategorieProduct,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategorieProduct  $categorieProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CategorieProduct $categorieProduct,$id)
    {
        $categorieProduct = CategorieProduct::find($id);

        return $categorieProduct;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategorieProduct  $categorieProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CategorieProduct $categorieProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategorieProduct  $categorieProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategorieProduct $categorieProduct, $id)
    {
        $categorieProduct = CategorieProduct::findOrFail($id);
        $categorieProduct->update($request->all());

        return $categorieProduct;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategorieProduct  $categorieProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategorieProduct $categorieProduct, $id)
    {
        $categorieProduct = CategorieProduct::destroy($id);
        return response()->json([
            "success" => true,
            "message" => "catégorie delete succssfully"
        ], 200);
    }
}
