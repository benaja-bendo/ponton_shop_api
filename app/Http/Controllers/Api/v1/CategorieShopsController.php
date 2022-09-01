<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\CategorieShop;
use App\Http\Controllers\Controller;

class CategorieShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorieShops = CategorieShop::all();

        return response()->json([
            "success" => true,
            "message" => "all catégories shops",
            'data' => [
                "version" => "1.0",
                "language" => app()->getLocale(),
                "support" => env("APP_SUPPORT")
            ],
            'catégorie-shops' => $categorieShops,
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
            'name' => 'required'
        ]);

        $categorieShop = CategorieShop::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "catégorie create succssfully",
            'categorieShop' => $categorieShop,
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
        $categorieShop = CategorieShop::findOrFail($id);

        return $categorieShop;
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

        $categorieShop = CategorieShop::findOrFail($id);
        $categorieShop->update($request->all());

        return $categorieShop;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorieShop = CategorieShop::findOrFail($id);
        $categorieShop->destroy($id);

        return response()->json([
            "success" => true,
            "message" => "catégorie delete succssfully"
        ], 200);
    }
}
