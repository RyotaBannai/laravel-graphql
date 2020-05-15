<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function upperName()
    {
        return Str::upper($this->name);
    }
}
