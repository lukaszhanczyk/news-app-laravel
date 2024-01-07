<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiSourceResource;
use App\Models\ApiSource;
use Illuminate\Http\Request;

class ApiSourceController extends Controller
{
    public function index()
    {
        return ApiSourceResource::collection(
            ApiSource::all()
        );
    }
}
