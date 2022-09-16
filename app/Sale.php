<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Supplier;
use App\Product;
use App\ModeOfPayment;
use App\Store;
use Carbon;
class Sale extends Model
{


    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sales';

    protected $guarded = ['id'];

    protected $fillable = [

         'transaction_id',
         'product_id',
         'supply',
         'supply_date',
         'serial_no',
         'quantity_buy',
         'sale_price',
         'pieces_quantity',
         'supply',
         'pieces_sales_price',
         'gain',
         'lost',
         'sale_date',
         'budget_year_id',
         'user_id',
         'total_amount',
         'store_id',
         'promo_qt',
    ];

    // One invoices has many StockOther...
    public function product() {
        return $this->belongsTo('App\Product');
    }

     public function user () {
        return $this->belongsTo('App\User');
    }
    public function transaction () {
        return $this->belongsTo('App\Transaction');
    }
     public function mode_of_payment () {
        return $this->belongsTo('App\ModeOfPayment');
    }
     public function store () {
        return $this->belongsTo('App\Store');
    }

}
