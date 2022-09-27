<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SliderImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliderImages = SliderImage::all();

        return response()->json([
            'success' => true,
            'message' => 'all sliders images',
            'data' => [
                'sliderImages' => $sliderImages,
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
        $this->validate($request,
        [
            'image_path' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'status' => 'required|boolean'
        ]);

        $ImagePath = null;

        if ($request->hasFile("image_path")) {
            $ImagePath = saveFileToStorageDirectory($request,"image_path","Slider_images");
        }

        $data = SliderImage::create(
            [
                'image_path' => $ImagePath,
                'status' => $request->status
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Slider Image create succssfully',
            'data' => [
                'Slider Image' => $data,
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
        $sliderImage = SliderImage::findOrFail($id);

        return $sliderImage;
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
        $this->validate($request,
        [
            'image_path' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'status' => 'required|boolean'
        ]);

        $sliderImage = SliderImage::findOrFail($id);

        $ImagePath = null;

        if ($request->hasFile("image_path")) {
            $ImagePath = saveFileToStorageDirectory($request,"image_path","Slider_images");
        }

        $sliderImage->update(
            [
                'image_path' => $ImagePath,
                'status' => $request->status
            ]
        );

        return $sliderImage;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sliderImage = SliderImage::findOrFail($id);
        $sliderImage->destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'image slider delete succssfully'
        ], 200);

    }
}
