<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    //

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
}
