<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Price;
use App\DailyExpense;

class Expense extends Model
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'expenses';

    protected $guarded = ['id'];

    protected $fillable = [
        'expenses_name','visible',
    ];

    public function daily_expense()
    {
        return $this->hasMany('App\DailyExpense');
    }

}

