<?php

namespace App\Models;

use App\Traits\AddBlogIdOnBoot;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostSeries extends Model
{
    use AddBlogIdOnBoot;
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'description', 'blog_id'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->visible();
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
}
