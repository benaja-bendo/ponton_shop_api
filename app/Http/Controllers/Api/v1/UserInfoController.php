<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserInfoController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userInfos = UserInfo::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'all UserInfo',
            'data' => [
                'userInfo' => $userInfos,
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
        $this->validate($request, [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'address' => 'string|max:255',
            'code_postal' => 'string|max:255',
            'city' => 'string|max:255',
            'phone' => 'string|max:255',
            'user_id' => 'required',
        ]);


        $userInfo = UserInfo::create($request->all());

        return response()->json([
            'success' => true,
            'message' => "Info user create succssfully",
            'data' => [
                'userInfo' => $userInfo,
            ]
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
        $userInfo = UserInfo::findOrFail($id);

        return $userInfo;
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
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'address' => 'string|max:255',
            'code_postal' => 'string|max:255',
            'city' => 'string|max:255',
            'phone' => 'string|max:255',
            'user_id' => 'required',
        ]);

        $userInfo = UserInfo::findOrFail($id);
        $userInfo->update($request->all());

        return $userInfo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userInfo = UserInfo::findOrFail($id);
        $userInfo->destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Info user delete succssfully'
        ], 200);
    }
}
