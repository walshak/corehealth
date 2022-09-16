<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorBooking extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'booked_by',
        'status',
        'time',
        'paid',
        'transaction_id',
        'fee',
        'appointment_id'
    ];

    public function doctor(){
        return $this->belongsTo('App\Doctor','doctor_id','id');
    }

    public function patient(){
        return $this->belongsTo('App\Patient','patient_id','id');
    }
}
