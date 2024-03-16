<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\Blog;
use App\Models\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasValidApiKey
{
    private const QUERY_KEY_NAME = "api_key";
    private const HEADER_KEY_NAME = "X-Nimbus-Api-Key";

    /**
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        // we only care about API requests
        if (!str_starts_with($request->path(), "api/")) {
            return $next($request);
        }

        $apiKey = $request->get(self::QUERY_KEY_NAME) ?? $request->header(self::HEADER_KEY_NAME);

        if (!$apiKey) {
            throw new AuthorizationException("Invalid API key");
        }

        /** @var ApiKey $keyRecord */
        $keyRecord = ApiKey::query()->where("api_key", $apiKey)->first();

        if (!$keyRecord) {
            throw new AuthorizationException("Invalid API key");
        }

        /** @var User $user */
        $user = $keyRecord->user()->first();

        /** @var Response $response */
        $response = $next($request);

        /** @var Blog|null $blog */
        $blog = $request->route()->parameter("blog");

        // if it's a non blog scoped resource we don't give a shit what this is
        if (!$blog) {
            return $response;
        }

        $userBlog = $user->blogs()->find($blog);

        if ($userBlog) {
            return $response;
        }

        throw new AuthorizationException("Invalid API key");
    }
}
