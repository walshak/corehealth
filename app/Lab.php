<?php

namespace App;
use App\Patient;
use App\User;
use App\LabService;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'labs';
     protected $guarded = ['id'];
    protected $fillable = [
        'lab_name',
        'description',
        'visible',


    ];
    
    public function labServices()
	{
	    return $this->hasMany('App\labService');
	} 
}
