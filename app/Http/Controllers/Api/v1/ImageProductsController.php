<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\ImageProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imagesProduct = ImageProduct::all();

        return response()->json([
            'success' => true,
            'message' => 'all products',
            'data' => [
                'imagesProduct' => $imagesProduct,
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
        $this->validate($request, [
            'path' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'cover' => 'boolean',
            'product_id' => 'required'
        ]);

        $path = null;

        if ($request->hasFile("path")) {
            $path = saveFileToStorageDirectory($request,"path","images_products");
        }

        $data = ImageProduct::create(
            [
                'path' => $path,
                'cover' => $request->cover,
                'product_id' => $request->product_id
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'ImageProduct create succssfully',
            'data' => [
                'image' => $data,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = ImageProduct::findOrFail($id);

        return $image;
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
        $this->validate($request, [
            'path' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'cover' => 'boolean',
            'product_id' => 'required'
        ]);

        $image = ImageProduct::findOrFail($id);

        $path = null;

        if ($request->hasFile("path")) {
            $path = saveFileToStorageDirectory($request,"path","images_products");
        }

        $image->update(
            [
                'path' => $path,
                'cover' => $request->cover,
                'product_id' => $request->product_id
            ]
        );

        return $image;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
