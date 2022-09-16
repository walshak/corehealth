<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Supplier;
use App\Transaction;
use App\ModeOfPayment;
use Carbon;

class SupplyAndPayment extends Model
{
   
   
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'supply_and_payments'; 
    
    protected $guarded = ['id'];

    protected $fillable = [

         'transaction_id','supplier_id', 'supply_amount', 'invoice_no', 'pay_amount', 'mode_of_payment_id','transaction_date','details', 'staff_id','deposit_b4','credit_b4', 'visible',
    ];

    // One supplier id has many supply and many sales...
   
    public function supplier () {
        return $this->belongsTo('App\Supplier');

    } 
    
     
      public function mode_of_payment () {
        return $this->belongsTo('App\ModeOfPayment');
    } 

}


