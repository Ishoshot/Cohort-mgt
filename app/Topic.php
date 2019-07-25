<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $guarded = [];

    public function track(){
        return $this->belongsTo(Track::class);
    }
}
