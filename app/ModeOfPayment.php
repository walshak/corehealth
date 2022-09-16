<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ModeOfPayment extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'mode_of_payments';

    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'payment_mode',
        'visible'
    ];


     public function user () {
        return $this->belongsTo('App\User');
    }

    public function transaction () {

        return $this->hasMany('App\Transaction', 'mode_of_payment_id', 'id');
    }
    public function supply_and_payment () {

        return $this->hasMany('App\SupplyAndPayment');
    }
}
