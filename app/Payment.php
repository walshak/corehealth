<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{   
	 protected $table = 'payments';
     protected $guarded = ['id'];
     protected $fillable = [
      'user_id',
	  'clinic_id',
	  'registrationNo',
	  'fullname',
	  'email', 
	  'referenceNo', 
	  'orderId',
	  'amount_paid', 
	  'total_amount',
	  'expected_amount',
	  'transactionid',
	  'rrr', 
	  'paymentType_id',
	  'payment_mode',
	  'status_id', 


    ];
}
