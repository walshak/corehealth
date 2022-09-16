<?php

namespace App;
use App\PaymentType;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
     protected $table = 'payment_items';
     protected $guarded = ['id'];
     protected $fillable = [
      'item_name', 'amount', 'visible', 'description',


    ];
    public function paymentType (){
        return $this->belongsTo('App\PaymentType');
    }
 
}
