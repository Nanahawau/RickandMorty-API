<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    //
    public function comment()
    {
        return $this->hasMany(\App\Comment::class);
    }
}
