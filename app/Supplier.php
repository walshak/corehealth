<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Invoice;

class Supplier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'suppliers';

    protected $guarded = ['id'];

    protected $fillable = [
        'company_name',
        'address',
        'phone',
        'created_by',
        'last_payment',
        'last_payment_date',
        'last_buy_date',
        'last_buy_amount',
        'credit',
        'deposit',
        'tootal_deposite',
        'date_line',
        'visible',
    ];

    // One narrator has many tales...
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
