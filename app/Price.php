<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Product;
use App\Stock;
use Carbon;

class Price extends Model
{
    
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'prices'; 
    
    protected $guarded = ['id'];

    protected $fillable = [

		  
    ];

    // One invoices has many StockOther...
    public function product() {
        return $this->belongsTo('App\Product');
    } 
    public function stock() {
        return $this->belongsTo('App\Stock','product_id');
    }
   
   
    
}
