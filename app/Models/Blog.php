<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model implements HasName
{
    use HasFactory;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_blogs');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function postSeries(): HasMany
    {
        return $this->hasMany(PostSeries::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function getFilamentName(): string
    {
        return $this->title;
    }
}
