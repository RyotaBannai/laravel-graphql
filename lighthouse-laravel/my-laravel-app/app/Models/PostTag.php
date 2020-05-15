<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

// class PostTag extends Model
class PostTag extends Pivot // Pivot にメソッドなどを持たせたい。。
{
    public function hello(): string {
        return "Hello, World. This is the method of pivot table.";
    }
}
