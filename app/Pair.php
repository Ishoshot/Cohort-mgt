<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    protected $guarded = [];

    public function cohort()
    {
        return $this->hasMany(Cohort::class);
    }
    public function student()
    {
        return $this->haMany(Student::class);
    }

}
