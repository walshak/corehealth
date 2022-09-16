<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InconclusiveMedicalReport extends Model
{
     protected $table = 'inconclusive_medical_reports';
     protected $guarded = ['id'];
     protected $fillable = [
      'transaction_no',
      'medical_report_id',
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
      'report_date',

    ];
    
    
     public function medicalReport () {
        return $this->belongsTo('App\MedicalReport','user_id','id');
    }
     public function user () {
        return $this->belongsTo('App\User','user_id','id');
    }
}
