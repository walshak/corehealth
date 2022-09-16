<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Product;
class Stock extends Model
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'stocks'; 
    
    protected $guarded = ['id'];

    protected $fillable = [
        'product_id', 'initial_quantity', 'order_quantity', 'current_quantity', 'current_value', 'quantity_sale','created_at', 'updated_at',
    ];

    // One product has one stock tales...
   
     
     public function product () {
        return $this->belong('App\Product');
    }
}
