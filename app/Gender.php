<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    //

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient','id','gender');
    }
}
