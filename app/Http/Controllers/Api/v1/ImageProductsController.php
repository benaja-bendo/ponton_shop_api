<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\v1\ImageProduct\ImageProductResource;
use App\Models\ImageProduct;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageProductsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
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
            'message' => 'ImageProduct create success',
            'data' => new ImageProductResource($imagesProduct)
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param ImageProduct $imageProduct
     * @return ImageProductResource
     */
    public function show(ImageProduct $imageProduct): ImageProductResource
    {
        return new ImageProductResource($imageProduct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ImageProduct $imageProduct
     * @return JsonResponse
     */
    public function update(Request $request, ImageProduct $imageProduct): JsonResponse
    {
        $request->validate([
            'path' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'product_id' => 'required'
        ]);
        $imageProduct->path = saveFileToStorageDirectory($request, "path", "images_products");
        $imageProduct->save();
        return response()->json([
            'success' => true,
            'message' => 'ImageProduct update success',
            'data' => new ImageProductResource($imageProduct)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ImageProduct $imageProduct
     * @return JsonResponse
     */
    public function destroy(ImageProduct $imageProduct): JsonResponse
    {
        $imageProduct->delete();
        return response()->json([
            'success' => true,
        ], 200);
    }
}
