<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(Blog $blog): AnonymousResourceCollection
    {
        $posts = $blog->posts()
            ->where('is_draft', false)
            ->where(function (Builder $query) {
                $query->where('starttime', null)
                    ->orWhere('starttime', '<=', now()->getTimestamp() * 1000);
            });

        return PostResource::collection($posts->paginate(50));
    }

    public function show(Blog $blog, Post $post): PostResource
    {
        return PostResource::make($post->load(['links', 'tags']));
    }
}
