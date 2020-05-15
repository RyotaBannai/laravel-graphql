<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserGroup extends Pivot
{
    protected $table = "user_group"; // これは宣言しなくても大丈夫なはず

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
