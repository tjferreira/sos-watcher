<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public function county()
    {
        return $this->belongsTo('App\County');
    }
}
