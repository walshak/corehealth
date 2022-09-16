<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
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
        return $this->hasMany('App\User', 'visible', 'id');
    }

    public function appointment()
    {
        return $this->hasMany('App\Appointment', 'apStatus_id', 'id');
    }

    public function category()
    {
        return $this->hasMany('App\Category');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
}
