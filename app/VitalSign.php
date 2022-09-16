<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $fillable = [
        'user_id',
        'dependant_id',
        'receptionist_id',
        'nurse_id',
        'medical_report_id',
        'file_no',
        'temperature',
        'weight',
        'bloodPressure',
        'VitalSignReport',
        'status',
        'paymentVisibility',
        'dateProccessed',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
