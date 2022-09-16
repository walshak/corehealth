<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class MedicalReport extends Model
{
    protected $table = 'medical_reports';
    protected $guarded = ['id'];
    protected $fillable = [
        'transaction_no',
        'dependant_id',
        'user_id',
        'doctor_id',
        'pharmacy_id',
        'nurse_id',
        'pateintDiagnosisReport',
        'pharmacy',
        'pharmacy_status',
        'lab_status',
        'admission_status',
        'nurseContent',
        'nurseContent_status',
        'visible',
        'admission',
        'discharge',
        'dischargeChannel',

    ];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function patient()
    {
        return $this->belongsTo('App\Patient', 'user_id', 'user_id');
    }
    public function doctor(){
        return $this->belongsTo('App\Doctor','doctor_id','user_id');
    }
}
