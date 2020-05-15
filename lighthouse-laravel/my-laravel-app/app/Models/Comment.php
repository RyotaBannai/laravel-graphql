<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'target');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'target');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'target');
    }

    public function _comments()
    {
        return $this->morphedByMany(Comment::class, 'target');
    }
}
