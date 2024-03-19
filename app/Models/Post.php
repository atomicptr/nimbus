<?php

namespace App\Models;

use App\Enums\PostPublishingStatus;
use App\Traits\AddBlogIdOnBoot;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use AddBlogIdOnBoot;
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'content', 'post_series_id', 'author_id', 'blog_id', 'is_draft', 'starttime', 'promo_image', 'publish_date'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postSeries(): BelongsTo
    {
        return $this->belongsTo(PostSeries::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tagged_posts');
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
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function publishingStatus(): PostPublishingStatus
    {
        if ($this->is_draft) {
            return PostPublishingStatus::draft;
        }

        if ($this->starttime !== null && $this->starttime > now()) {
            return PostPublishingStatus::timed;
        }

        return PostPublishingStatus::published;
    }

    public function scopeVisible(Builder $query)
    {
        $query->where('is_draft', false)
            ->where(function (Builder $query) {
                $query->where('starttime', null)
                    ->orWhere('starttime', '<=', now()->getTimestamp() * 1000);
            });
    }
}
