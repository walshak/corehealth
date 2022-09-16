<?php

namespace App;
use App\CustomerBudget;
use App\BudgetYear;
use Carbon;

use Illuminate\Database\Eloquent\Model;

class BudgetYear extends Model
{
   // use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'budget_years'; 
    
    protected $guarded = ['id'];

    protected $fillable = [
        'year_name',
        'opening_date', 
        'closing_date',
        'closed', 
        'total_amount',
        'spending',
        'visible',
        'balance',
    ];

    public function customerBudget()
    {
        return $this->hasMany('App\CustomerBudget');
    }

    
    
}
