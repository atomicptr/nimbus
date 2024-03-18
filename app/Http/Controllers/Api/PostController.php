<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Post;
use App\Models\PostSeries;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(Blog $blog): AnonymousResourceCollection
    {
        $posts = $blog->posts()->visible()->orderBy('created_at', 'desc');

        return PostResource::collection($posts->with(['tags'])->paginate(50));
    }

    public function show(Blog $blog, Post $post): PostResource
    {
        $post->load(['links', 'tags', 'author', 'postSeries']);

        $postSeriesMeta = null;

        /** @var PostSeries|null $postSeries */
        $postSeries = $post->postSeries;

        if ($postSeries) {
            $postSeries->load('posts');

            // TODO: can probably be done without asking the DB but for our use case it also kinda does not matter rn
            $prev = $postSeries->posts()->where('created_at', '<', $post->created_at)->orderBy('created_at', 'desc')->first();
            $next = $postSeries->posts()->where('created_at', '>', $post->created_at)->orderBy('created_at')->first();

            $postSeriesMeta = $prev || $next ? [
                'title' => $postSeries->title,
                'previous' => $prev,
                'next' => $next,
            ] : null;
        }

        return PostResource::make($post)->additional([
            'meta_post_series' => $postSeriesMeta,
        ]);
    }
}
