<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SourceResource;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        return SourceResource::collection(
            Source::all()
        );
    }
}
