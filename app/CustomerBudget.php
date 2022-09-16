<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Customer;
use App\BudgetYear;
use Carbon;

class CustomerBudget extends Model
{
      //use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'customer_budgets'; 
    
    protected $guarded = ['id'];

    protected $fillable = [
        'customer_id', 
        'budget_year_id',
        'amount',
        'balance',
        'visible',
        'spending',
    ];

     public function budgetYear()
    {
        return $this->belongsTo('App\BudgetYear', 'budget_year_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }

   
 }
     
