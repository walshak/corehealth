<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'category_id',
        'product_name',
        'product_code',
        'reorder_alert',
        'has_have',
        'has_piece',
        'howmany_to',
        'visible',
        'current_quantity',
        'promotion',
    ];

    // One narrator has many tales...
    public function stoke_other()
    {
        return $this->hasMany('App\StokeOther');
    }

    // public function category()
    // {
    //     return $this->belongsTo('App\Category');
    // }

    public function stock()
    {
        return $this->hasOne('App\Stock');
    }

    public function price()
    {
        return $this->hasOne('App\Price');
    }

    public function product()
    {
        return $this->hasMany('App\Promotion');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function stock_ledge()
    {
        return $this->hasMany('App\StockLedge');
    }

    public function storeStock()
    {
        return $this->hasMany('App\StoreStoke', 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
