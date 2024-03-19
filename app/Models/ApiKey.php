<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'api_key'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (ApiKey $apiKey) {
            $apiKey->api_key ??= uuid_create();
            $apiKey->user_id ??= auth()->user()->id;
        });
    }
}
