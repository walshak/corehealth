<?php

namespace App;
use App\Patient;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
	 protected $table = 'clinics';
     protected $guarded = ['id'];
    protected $fillable = [
        'clinic_name',
        'description',
        'clinic_note_format',
        'visible',


    ];

    public function patients()
	{
	    return $this->hasMany(App\Patient::class, 'clinic_id');
	}

    public function doctor(){
        return $this->hasMany('App\Doctor','clinic_id');
    }

}
