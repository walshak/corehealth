<?php

namespace App;
use App\Lab;

use Illuminate\Database\Eloquent\Model;

class LabService
 extends Model
{
     protected $table = 'lab_services';
     protected $guarded = ['id'];
     protected $fillable = [
        'lab_service_name',
        'lab_id',
        'description',
        'visible',


    ];
    
    public function lab()
	{
	    return $this->belongsTo('App\Lab');
	} 
}
