<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'author_id', 'title', 'body'
    ];

    public function author() {
        return $this->belongsTo(User::class);
    }
}
