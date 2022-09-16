<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Supplier;
use App\StockOrder;
use Carbon;

class Invoice extends Model
{
    
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'invoices'; 
    
    protected $guarded = ['id'];

    protected $fillable = [

		  'invoice_no',
		  'supplier_id', 
		  'invoice_date', 
		  'created_by',
		  'number_of_products', 
		  'total_amount', 
		  'visible',
		  'created_by',
    ];

    // One invoices has many StockOther...
    public function supplier() {
        return $this->belongsTo('App\Supplier');
    }
     
    public function category () {
        return $this->belongsTo('App\Supplier');
    }

    public function stock_order () {
        return $this->hasMany('App\StockOrder');
    }
  
   
    
}
