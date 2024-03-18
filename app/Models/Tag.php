<?php

namespace App\Models;

use App\Traits\AddBlogIdOnBoot;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use AddBlogIdOnBoot;
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'blog_id'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'tagged_posts')->visible();
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
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
