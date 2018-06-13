<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $guarded = [];
    public function county()
    {
        return $this->belongsTo('App\County');
    }
    public function results()
    {
        return $this->hasMany('App\Result');
    }
    public function candidates()
    {
        return $this->belongsToMany('App\Candidate');
    }
}