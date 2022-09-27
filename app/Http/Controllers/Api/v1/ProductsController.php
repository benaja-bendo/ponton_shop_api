<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\v1\Product\ProductCollection;
use App\Http\Resources\v1\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     */
    public function index(): ProductCollection
    {
        $products = Product::paginate();
        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'small_description' => 'required|string',
            'long_description' => 'string',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'message' => "product create succssfully",
            'data' => [
                'product' => $product,
            ]
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return ProductResource
     */
    public function update(Request $request, Product $product): ProductResource
    {
        $request->validate([
            'name' => 'required',
            'small_description' => 'required|string',
            'long_description' => 'string',
            'price' => 'required|numeric',
        ]);
        $product->update($request->all());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'product delete succssfully'
        ], 200);
    }

    /**
     * @param Request $request
     * @param string $query
     * @return ProductCollection
     */
    public function search(Request $request, string $query): ProductCollection
    {
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('small_description', 'like', '%' . $query . '%')
            ->orWhere('long_description', 'like', '%' . $query . '%')
            ->paginate(15);
        return new ProductCollection($products);
    }
}
