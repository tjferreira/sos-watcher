<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $guarded = [];
    public function races()
    {
        return $this->hasMany('App\Race');
    }
    public function candidates()
    {
        return $this->belongsToMany('App\Candidate');
    }
}