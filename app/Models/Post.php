<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    public function author(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function postSeries(): ?HasOne
    {
        return $this->hasOne(PostSeries::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, "tagged_posts");
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
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
