<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'appointments';

    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'user_id',
        'doctor_id',
        'apStartDate',
        'apEndDate',
        'apStatus_id',
        'waitTime',
        'created_at',
        'updated_at'
    ];

    // One invoices has many StockOther...
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'apStatus_id', 'id');
    }

}
