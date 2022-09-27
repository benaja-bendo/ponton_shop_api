<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();

        return response()->json([
            'success' => true,
            'message' => 'all shops',
            'data' => [
                'shops' => $shops,
            ],
        ],200);
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
            'name' => 'required|string|max:255',
            'description' => 'string',
            'address' => 'string',
            'city' => 'string',
            'postal_code' => 'string',
            'web' => 'string|max:255',
            'email' => 'required|string|email',
            'telephone' => 'string',
        ]);

        $shop = Shop::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'shop create succssfully',
            'data' => [
                'shop' => $shop,
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
        $shop = Shop::findOrFail($id);

        return $shop;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string',
            'address' => 'string',
            'city' => 'string',
            'postal_code' => 'string',
            'web' => 'string|max:255',
            'email' => 'required|string|email',
            'telephone' => 'string',
        ]);

        $shop = Shop::FindOrFail($id);
        $shop->update($request->all());

        return $shop;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = shop::findOrFail($id);
        $shop->destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'shop delete succssfully'
        ], 200);
    }
}
