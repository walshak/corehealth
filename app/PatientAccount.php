<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientAccount extends Model
{
     protected $table = 'patient_accounts';

    protected $guarded = ['id'];

    protected $fillable = [
	  'user_id',
	  'file_no',
	  'deposit',
	  'creadit',
	  'credit_b4',
	  'deposite_b4',
	  'visible',
	  'last_amount_paid',
	  'last_payment_date',
	];

	public function patient() {
        return $this->belongsTo('App\Patient','user_id','user_id');
    }
}
