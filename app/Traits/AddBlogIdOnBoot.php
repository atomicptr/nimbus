<?php

namespace App\Traits;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

trait AddBlogIdOnBoot
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->blog_id ??= $model->post ? $model->post->blog_id : Filament::getTenant()?->id;
        });
    }
}
