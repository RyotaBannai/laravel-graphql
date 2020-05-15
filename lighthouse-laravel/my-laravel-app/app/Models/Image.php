<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // morphリレーションを使っているためmass assignmentをする
    // loadする時に同じtarget_idでも区別して取ってこれる
    protected $guarded = ['id']; // blacklist // 「id」以外をcreateから渡すことができる

    // protected $guarted = []; // 全属性を複数代入可能にする場合
    // protected $fillable = []; // whitelist
}
