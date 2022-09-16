<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Clinic;
use App\Bed;


class Ward extends Model
{
    protected $table = 'wards';
     protected $guarded = ['id'];
    protected $fillable = [
        'ward_name',
        'clinic_id',
        'description',
        'visible',
        'price_assing',
        'bed_assing',


    ];
    
    public function bed()
	{
	    return $this->hasMany(App\Patient::class, 'clinic_id');
	} 
}
