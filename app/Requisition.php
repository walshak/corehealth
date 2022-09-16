<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Customer;


class Requisition extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'requisitions';
    protected $guarded = ['id'];
    protected $fillable = [
        'customer_id',
        'transaction_no',
        'request_user_id',
        'approve_user_id',
        'total_amount',
        'status',
        'request_date',
        'aprove_date',
        'visible',
    ];


    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }

    public function requisitionRequest()
    {
        return $this->hasMany('App\RequisitionRequest', 'requisition_id', 'id');
    }
}
