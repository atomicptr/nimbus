<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    public function author(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function postSeries(): ?HasOne
    {
        return $this->hasOne(PostSeries::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function blog(): HasOne
    {
        return $this->hasOne(Blog::class);
    }
}
