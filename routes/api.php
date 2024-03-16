<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostSeriesController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("blogs", BlogController::class)->only(["index", "show"]);
Route::apiResource("blogs.posts", PostController::class)->scoped(["posts" => "blog"])->only(["index", "show"]);
Route::apiResource("blogs.series", PostSeriesController::class)->scoped(["post_series" => "blog"])->only(["index", "show"]);
Route::apiResource("blogs.tags", TagController::class)->scoped(["tags" => "blog"])->only(["index", "show"]);
Route::apiResource("blogs.authors", AuthorController::class)->only(["index", "show"]);
