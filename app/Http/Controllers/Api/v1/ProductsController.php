<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            "success" => true,
            "message" => "all products",
            'data' => [
                "version" => "1.0",
                "language" => app()->getLocale(),
                "support" => env("APP_SUPPORT")
            ],
            'products' => $products,
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
            'small_description' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|',
        ]);
        $product = Product::create($request->all());

        return response()->json([
            "success" => true,
            "message" => "product create succssfully",
            'product' => $product,
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
        $product = Product::findOrFail($id);

        return $product;
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
        $product = Product::FindOrFail($id);
        $product->update($request->all());

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::destroy($id);
        return response()->json([
            "success" => true,
            "message" => "product delete succssfully"
        ], 200);
    }
}
