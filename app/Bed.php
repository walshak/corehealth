<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ward;

class Bed extends Model
{
    protected $table = 'beds';
    protected $guarded = ['id'];
    protected $fillable = [
        'bed_name',
        'ward_id',
        'describtion',
        'bed_type',
        'status', 
        'visible',
    ];
    
    public function ward()
	{
	    return $this->belongsTo('App\Ward');
	} 
}
