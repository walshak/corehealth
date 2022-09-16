<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Supplier;
use App\Stock;
use App\Store;
use App\Sale;
use App\Transaction;
use App\Promotion;
use Carbon;

class PromoSale extends Model
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'promo_sales'; 
    
    protected $guarded = ['id'];

    protected $fillable = ['product_id',
   'promotion_id',
   'transaction_id',
   'store_id',
   'quantity_buy',
   'quantity_give',
   'total_amount',
   'start_date',
   'end_date',
   'visible',
    ];

    // One transaction id has many products sales...
   
    public function transaction () {
        return $this->belongsTo('App\Transaction');

    } 
    public function store () {
        return $this->belongsTo('App\Store');

    }
    public function product () {
        return $this->belongsTo('App\Product');
    }
    public function promotion () {
        return $this->belongsTo('App\Promotion');
    } 
     
}
