<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function index()
    {
        return response()->json([
            "status" => "online",
            "version" => "1.0.0",
            "environment" => "docker"
        ], 200);
    }
}
