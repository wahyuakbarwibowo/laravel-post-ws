<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'is_draft',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_draft' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Active (published) posts */
    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('is_draft', false)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
