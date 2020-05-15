<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function getData()
    {
        return $this->id.':'.$this->name;
    }
}
