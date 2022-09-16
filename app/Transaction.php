<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{

    protected $table = 'transactions';

    protected $guarded = ['id'];
    protected $fillable = [
        'transaction_no',
        'budget_year_id',
        'transaction_type',
        'customer_name',
        'phone_number',
        'address',
        'total_amount',
        'deposit_b4',
        'credit_b4',
        'current_deposit',
        'current_credit',
        'customer_type_id',
        'mode_of_payment_id',
        'bank_transaction_payment_id',
        'store_id',
        'bank_name',
        'supply',
        'supply_date',
        'bank_transaction_id',
        'staff_id', 'tr_date',
        'tr_time', 'tr_year',
    ];

    public function sales()
    {

        return $this->hasMany('App\Sale');
    }

    public function promo_sale()
    {
        return $this->hasMany('App\PromoSale');
    }

    public function store()
    {

        return $this->belongsTo('App\Store', 'store_id', 'id');
    }

    public function mode_of_payment()
    {

        return $this->belongsTo('App\ModeOfPayment', 'mode_of_payment_id', 'id');
    }

    public function users()
    {

        return $this->belongsTo('App\User', 'staff_id', 'id');
    }

    public function hmo(){
        return $this->belongsTo('App\Hmo','hmo_id','id');
    }
}
