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
use App\PromoSale;
use App\Product;
use Carbon;

class Promotion extends Model
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'promotions'; 
    
    protected $guarded = ['id'];

    protected $fillable = ['product_id',
   'promotion_name',
   'quantity_to_buy',
   'quantity_to_give',
   'promotion_total_quantity',
   'start_date',
   'end_date',
   'current_qt',
   'give_qt',
   'visible',
    ];

    // One transaction id has many products sales...
   
    public function sales () {
        return $this->hasMany('App\Sale');

    } 
    public function store () {
        return $this->belongsTo('App\Store');

    }
    public function product () {
        return $this->belongsTo('App\Product');
    } 
    public function promo_sale () {
        return $this->hasMany('App\PromoSale');
    } 
    

}
