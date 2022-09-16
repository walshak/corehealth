<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependant extends Model
{
    //

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'patient_id', 'id');
    }

    public function hmo()
    {
        return $this->hasOne('App\Hmo', 'id', 'hmo_id');
    }

    public function medical_report()
    {
        return $this->hasMany('App\MedicalReport', 'dependant_id', 'id');
    }
    public function genderr(){
        return $this->hasOne('App\Gender','id','gender');
    }

    public function clinic()
    {
        return $this->belongsTo('App\Clinic', 'clinic_id', 'id');
    }

    public function nursing_notes(){
        return $this->hasMany(NursingNote::class,'dependant_id','id');
    }
}
