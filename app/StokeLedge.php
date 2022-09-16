<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokeLedge extends Model{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'stock_ledges';
    protected $guarded = ['id'];
    protected $fillable = [
        'product_id',
        'ledge_date',
        'in_coming',
        'out_goin',
        'Balance' ,
        'initial_balance' ,
        'user_id',
        'visible',
    ];


    public function product() {
        return $this->belongsTo('App\Product');
    }

    public function user(){
        return $this->belongsTo('App\User ');
    }

}

