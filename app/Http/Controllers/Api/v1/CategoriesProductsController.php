<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\v1\CategorieProduct\CategorieProductResource;
use Illuminate\Http\Request;
use App\Models\CategorieProduct;
use App\Http\Controllers\Controller;

//use App\Http\Resources\CategorieProductResource;
//use App\Http\Resources\CategorieProductResourceCollection;

class CategoriesProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|CategorieProductResource
     */
    public function index(): \Illuminate\Http\JsonResponse|CategorieProductResource
    {
        return new CategorieProductResource(CategorieProduct::paginate());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);
        $categorieProduct = CategorieProduct::create([
            'name' => $request->name
        ]);
        return response()->json([
            'success' => true,
            'message' => 'catégorie create success',
            'data' => new CategorieProductResource($categorieProduct),
        ], 201);
    }

    /**
     * @param CategorieProduct $categorieProduct
     * @return CategorieProductResource
     */
    public function show(CategorieProduct $categorieProduct): CategorieProductResource
    {
        return new CategorieProductResource($categorieProduct);
    }

    /**
     * @param Request $request
     * @param CategorieProduct $categorieProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, CategorieProduct $categorieProduct): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required|unique:categorie_products,name',
        ]);
        $categorieProduct->name = $request->name;
        $result = $categorieProduct->save();

        return response()->json([
            "success" => $result,
        ]);
    }

    /**
     * @param CategorieProduct $categorieProduct
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CategorieProduct $categorieProduct): \Illuminate\Http\JsonResponse
    {
        $resultat = $categorieProduct->delete();
        return response()->json([
            'success' => $resultat,
        ], 200);
    }
}
