<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    public function index(Blog $blog): AnonymousResourceCollection
    {
        $tags = $blog->tags();

        return TagResource::collection($tags->paginate(50));
    }

    public function show(Blog $blog, Tag $tag): TagResource
    {
        return TagResource::make($tag);
    }
}
