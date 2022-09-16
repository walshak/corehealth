<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Customer;
use App\Transaction;

class CustomerType extends Model
{
     use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'customer_types'; 
    
    protected $guarded = ['id'];

    protected $fillable = [

		  'type_name',
		  'visible',
    ];

    // One narrator has many tales...
    public function invoices() {
        return $this->hasMany('App\Customer');
    }

    public function customers() {
        return $this->hasMany('App\Customer');
    
    }
    
    

     
    
}
