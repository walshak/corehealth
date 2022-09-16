<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
class AccountType extends Model
{
     protected $table = 'account_types';
     protected $guarded = ['id'];
     protected $fillable = [
        'account_type_name',
        'visible',


    ];
    
    public function patients()
	{
	    return $this->hasMany(App\Patient::class, 'clinic_id');
	} 
}
