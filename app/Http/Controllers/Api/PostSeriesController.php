<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostSeriesResource;
use App\Models\Blog;

class PostSeriesController extends Controller
{
    public function index(Blog $blog)
    {
        $series = $blog->postSeries();

        return PostSeriesResource::collection($series->paginate(50));
    }

    public function show(Blog $blog, string $postSeriesId)
    {
        $postSeries = $blog->postSeries()->findOrFail($postSeriesId);

        return PostSeriesResource::make($postSeries->load('posts'));
    }
}
