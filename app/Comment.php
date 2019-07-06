<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $guarded = [];

    public function episode(){

        return $this->belongsTo(\App\Episode::class);
    }
}
