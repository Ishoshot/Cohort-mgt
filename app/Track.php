<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $guarded = [];

    public function topics(){
        return $this->hasMany(Topic::class);
    }
}
