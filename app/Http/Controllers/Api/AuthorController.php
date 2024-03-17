<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Blog;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function index(Blog $blog): AnonymousResourceCollection
    {
        $users = $blog->users();

        return AuthorResource::collection($users->paginate());
    }

    public function show(Blog $blog, string $id): AuthorResource
    {
        $user = $blog->users()->findOrFail($id);

        return AuthorResource::make($user);
    }
}
