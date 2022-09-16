<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Product;
class InitialStock extends Model
{
     use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'initial_stocks'; 
    
    protected $guarded = ['id'];

    protected $fillable = [
		  
	  'product_id',
	  'quantity',
      'visible',
		  	
    ];
    
     public function product () {
        return $this->belongsTo('App\Product');
    }
}
