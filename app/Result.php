<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = [];
    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }
    public function race()
    {
        return $this->belongsTo('App\Race');
    }
}
