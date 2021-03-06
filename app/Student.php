<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function cohort(){
        return $this->belongsTo(Cohort::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

}
