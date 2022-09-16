<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'title_id',
        'is_admin',
        'user_id',
        'status_id',
        'specialization_id',
        'gender_id',
        'date_of_birth',
        'secondary_email',
        'secondary_phone_number',
        'state_id',
        'lga_id',
        'contact_address',
        'home_address',
        'consultation_fee',
        'deleted',
    ];

    public function title()
    {
        return $this->belongsTo('App\Title');
    }

    public function booking(){
        return $this->hasMany('APP\DoctorBooking','doctor_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function specialization()
    {
        return $this->belongsTo('App\Specialization');
    }

    public function clinic()
    {
        return $this->belongsTo('App\Clinic','clinic_id','id');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function lga()
    {
        return $this->belongsTo('App\Lga');
    }

    public function medical_report(){
        return $this->hasMany('App\MedicalReport','doctor_id','id');
    }
}
