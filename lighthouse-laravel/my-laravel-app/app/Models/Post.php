<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'target');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'target');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->using(PostTag::class);
    }

    public function snippet(): string
    {
        return Str::words($this->content, 10, ' >>>');
    }

    public function author(): BelongsTo
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'user_id', 'id'); // foreign keyを帰ればキーやテーブル名と関数名と別でもok
    }
}
