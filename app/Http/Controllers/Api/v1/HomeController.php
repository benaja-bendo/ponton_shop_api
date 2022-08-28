<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return [
            "success" => true,
            "message" => "welcome to PONTON_SHOP API",
            'data' => [
                "version" => "1.0",
                "language" => app()->getLocale(),
                "support" => env("APP_SUPPORT")
            ]
        ];
    }
}
