<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tag extends Model
{
    use HasFactory;
    use Sluggable;

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, "tagged_posts");
    }

    public function blog(): HasOne
    {
        return $this->hasOne(Blog::class);
    }

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "title",
            ],
        ];
    }
}
