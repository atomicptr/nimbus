<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostSeriesController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("authors", AuthorController::class);
Route::apiResource("blogs", BlogController::class);
Route::apiResource("blogs.posts", PostController::class);
Route::apiResource("blogs.series", PostSeriesController::class);
Route::apiResource("blogs.tags", TagController::class);
