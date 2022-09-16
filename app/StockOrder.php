<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Supplier;
use App\Product;
use Carbon;
use Auth;


class StockOrder extends Model
{
   

    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'stock_orders'; 
    
    protected $guarded = ['id'];

    protected $fillable = [
		  'invoice_id',
		  'product_id',
		  'order_quantity', 
		  'total_amount', 
          'store_id', 
          'stock_date', 
		  	
    ];

    // One stock_order has many StockOther...
    public function invoice() {
        return $this->belongsTo('App\Invoice');
    }
     
     public function product () {
        return $this->belongsTo('App\Product');
    }
  
}
