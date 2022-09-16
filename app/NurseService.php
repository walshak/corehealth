<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NurseService extends Model
{
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'nurse_services'; 
    
    protected $guarded = ['id'];

    protected $fillable = [
	  'user_id',
	  'medical_report_id',
	  'transaction_id',
	  'file_no',
	  'charge_amount',
	  'service_description',
	  'nurse_user_id',
	  'payment_status',
	  'payment_date',
	  'visible',
    ];

}
