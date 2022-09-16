<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyExpense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'daily_expenses';

    protected $guarded = ['id'];

    protected $fillable = [

          'expense_id',
          'beneficiary',
          'amount',
          'mode_payment',
          'visible',
          'user_id',
    ];

    public function expense() {

        return $this->belongsTo('App\Expense');
    }

    public function user()
    {
        return $this->hasMany('App\User', 'user_id', 'id');
    }

}



