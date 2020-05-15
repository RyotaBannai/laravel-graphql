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
    // use Searchable;

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'target'); // 親はmorphの立場なのでmorph名を加えてポリモーフィックリレーションを作成

        // target_idが投稿id、target_typeの投稿モデルのクラス名（Post::class）となり、画像がどの投稿の添付であるかを判別
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'target');
    }

    public function tags(): BelongsToMany
    {
        // return $this->belongsToMany(Tag::class); // Laravel　に自動で認識させたいなら、このままで十分 で post_tag tableを読み込む // id は tablename_id
        // return $this->belongsToMany(Tag::class, post_tags); // pivot tableが別名の場合第二引数に渡す. idも違う場合は、第三、第四引数で渡す
        return $this->belongsToMany(Tag::class)->using(PostTag::class);
        // ->withPivot(‘カラム名’)で中間テーブルのカラムを取得
    }

    public function snippet(): string
    {
        return Str::words($this->content, 10, ' >>>');
    }
}
