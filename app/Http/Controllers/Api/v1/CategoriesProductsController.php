<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\CategorieProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategorieProductResource;
use App\Http\Resources\CategorieProductResourceCollection;

class CategoriesProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $CategorieProducts = CategorieProduct::all();

        return response()->json([
            'success' => true,
            'message' => 'all catégories products',
            'data' => [
                'CategorieProducts' => new CategorieProductResourceCollection($CategorieProducts),
                // 'CategorieProducts' => CategorieProductRessource::collection($CategorieProducts),
            ],

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
            'name'=>'required',
        ]);

        $CategorieProduct = CategorieProduct::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'catégorie create succssfully',
            'data' => [
                'CategorieProduct' => $CategorieProduct,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategorieProduct  $categorieProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CategorieProduct $categorieProduct,$id)
    {
        $categorieProduct = CategorieProduct::findOrFail($id);

        return new CategorieProductResource($categorieProduct);
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
        $request->validate([
            'name'=>'required',
        ]);

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
        $categorieProduct = CategorieProduct::findOrFail($id);
        $categorieProduct = CategorieProduct::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'catégorie delete succssfully'
        ], 200);
    }
}
