<?php

namespace App;

use App\User;
use App\Clinic;
use App\PatientAccount;
use App\AccountType;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'file_no',
        'clinic_id',
        'gender',
        'blood_group',
        'genotype',
        'hieght',
        'disability',
        'weight',
        'current_service_status',
        'dieses_id',
        'account_type_id',
        'last_visiting_date',
        'address',
        'nationality',
        'lga',
        'province',
        'visible',


    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function clinic()
    {
        return $this->belongsTo('App\Clinic', 'clinic_id', 'id');
    }

    public function booking(){
        return $this->hasMany('APP\DoctorBooking','patient_id','id');
    }

    public function account_type()
    {
        return $this->belongsTo('App\AccountType', 'account_type_id', 'id');
    }

    public function patientAcount()
    {
        return $this->hasOne('App\PatientAccount', 'user_id', 'id');
    }

    public function hmo()
    {
        return $this->hasOne('App\Hmo', 'id', 'hmo_id');
    }

    public function medical_report()
    {
        return $this->hasMany('App\MedicalReport', 'user_id', 'user_id');
    }
    public function genderr(){
        return $this->hasOne('App\Gender','id','gender');
    }
    public function lgaa(){
        return $this->hasOne('App\Lga','id','lga');
    }

    public function ward_notes(){
        return $this->hasMany('App\WardNote','patient_id','id');
    }

    public function nursing_notes(){
        return $this->hasMany(NursingNote::class,'patient_id','id');
    }
}
