<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\v1\Product\ProductCollection;
use App\Http\Resources\v1\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     */
    public function index(): ProductCollection
    {
        return new ProductCollection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
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
     * @param Request $request
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addOneImage(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'product_id' => 'required'
        ]);
        $product = Product::findOrFail($request->product_id);
        $imagesProduct = $product->imageProduct()->create([
            "path" => saveFileToStorageDirectory($request, 'path', 'images_product'),
        ]);
        return response()->json([
            'success' => true,
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeOneImage(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required',
            'image_products_id' => 'required'
        ]);
        $product = Product::findOrFail($request->product_id);
        $resultat = $product->imageProduct()->delete($request->image_products_id);
        return response()->json([
            'success' => $resultat,
        ], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addCategorie(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'categorie_product_id' => 'required|exists:categorie_products,id',
        ]);
        $product = Product::findOrFail($request->product_id);
        $product->categories()->attach($request->categorie_product_id);
        return response()->json([
            "success" => true,
            "data" => new ProductResource($product)
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeCategorie(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'categorie_product_id' => 'required|exists:categorie_products,id',
        ]);
        $product = Product::findOrFail($request->product_id);
        $product->categories()->detach($request->categorie_product_id);
        return response()->json([
            "success" => true,
            "data" => new ProductResource($product)
        ], 200);
    }
}
