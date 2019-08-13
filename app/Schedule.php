<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function cohort(){
        return $this->belongsTo(Cohort::class);
    }
}
