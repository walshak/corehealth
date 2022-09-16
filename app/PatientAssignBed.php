<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bed;
class PatientAssignBed extends Model
{
     protected $table = 'patient_assign_beds';
    protected $guarded = ['id'];
    protected $fillable = [
        'patient_user_id',
        'medical_report_id',
        'ward_id',
        'bed_id',
        'bedCharges',
        'numberDays',
        'disChargeDate',
        'amountPaid',
        'payment_status',
        'partPayment',
        'discountPayment'
    ];


    public function bed()
	{
	    return $this->belongsTo('App\Bed');
	}
}
