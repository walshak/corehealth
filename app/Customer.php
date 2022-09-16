<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\CustomerType;
use App\StockOrder;
use Carbon;

class Customer extends Model
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'customers';

    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'fullname',
        'code',
        'credit_limit',
        'customer_type_id',
        'phone',
        'address',
        'next_of_kin',
        'nk_phone',
        'nk_address',
        'relationship',
        'remark',
        'totalbuy',
        'tootal_deposite',
        'creadit',
        'deposit',
        'balance',
        'total_borrows',
        'borrow',
        'credit_b4',
        'deposite_b4',
        'date_line',
        'visible',
        'created_at',
        'updated_at'
    ];

    // One invoices has many StockOther...
    public function customer_type()
    {
        return $this->belongsTo('App\CustomerType');
    }

    public function requisition()
    {
        return $this->belongsTo('App\Requisition', 'customer_id', 'id');
    }
}
