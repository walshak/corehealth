<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';

    /**
     * The State attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name',
        'status'
    ];

    /**
     * Get the applicantPersonalDetail record associated with the LGA.
     */
}
