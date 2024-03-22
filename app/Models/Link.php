<?php

namespace App\Models;

use App\Traits\AddBlogIdOnBoot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Link extends Model
{
    use AddBlogIdOnBoot;
    use HasFactory;

    protected $fillable = ['title', 'description', 'link', 'archive_link', 'sort'];

    public function blog(): HasOne
    {
        return $this->hasOne(Blog::class);
    }

    public function post(): HasOne
    {
        return $this->hasOne(Post::class);
    }
}
