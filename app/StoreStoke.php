<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreStoke extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'store_stokes';

    protected $guarded = ['id'];

    protected $fillable = [
        'store_id',
        'product_id',
        'initial_quantity',
        'quantity_sale',
        'order_quantity',
        'current_quantity',
    ];

    // One product has one stock tales...


    public function product()
    {
        return $this->hasMany('App\Product', 'product_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
