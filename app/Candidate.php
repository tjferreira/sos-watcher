<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $guarded = [];
    public function counties()
    {
        return $this->belongsToMany('App\County');
    }
    public function races()
    {
        return $this->belongsToMany('App\Race');
    }    
    public function results()
    {
        return $this->hasMany('App\Result');
    }    
}
