<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    protected $guarded = [];

    public function track(){
        return $this->belongsTo(Track::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }
    public function schedule(){
        return $this->hasOne(Schedule::class);
    }
}
