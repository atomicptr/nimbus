<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        // TODO: for the current user api key
        return BlogResource::collection(Blog::all());
    }

    public function show(Blog $blog): BlogResource
    {
        return BlogResource::make($blog);
    }
}
