<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\MedicalReport;
use App\Clinic;
use App\PatientLab;
use App\Lab;
use App\LabService;
use App\User;

class PatientLabService extends Model
{
    protected $table = 'patient_lab_services';

    protected $guarded = ['id'];

    protected $fillable = [
        'patient_user_id',
        'dependant_id',
        'lab_user_id',
        'medical_report_id',
        'lab_id',
        'lab_service_id',
        'payment_status',
        'payment_date',
        'transaction_id',
        'visible',
        'sampeTaken',
        'sampeDate',
        'sample_taken_by',
        'resultReport_by',
        'resultReport',
        'resultDate'

   ];
   public function lab()
    {
        return $this->belongsTo('App\Lab','lab_id','id');
    }
    public function lab_service()
    {
        return $this->belongsTo('App\LabService', 'lab_service_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'patient_user_id', 'id');
    }

    public function medical_report()
    {
        return $this->belongsTo('App\MedicalReport', 'medical_report_id', 'id');
    }

}
