<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostSeriesResource;
use App\Models\Blog;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostSeriesController extends Controller
{
    public function index(Blog $blog): AnonymousResourceCollection
    {
        $series = $blog
            ->postSeries()
            ->orderBy('created_at', 'desc');

        return PostSeriesResource::collection($series->paginate(50));
    }

    public function show(Blog $blog, string $postSeriesId): PostSeriesResource
    {
        $postSeries = $blog->postSeries()->findOrFail($postSeriesId);

        return PostSeriesResource::make($postSeries->load('posts'));
    }
}
