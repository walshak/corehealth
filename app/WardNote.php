<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class WardNote extends Model
{
    use HasRoles;

    public function patient(){
        return $this->belongsTo('App\Patient');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
