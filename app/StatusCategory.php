<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'visible', 
    ];

    public function user()
    {
    	return $this->hasMany('App\User', 'is_admin', 'id');
    }
}
