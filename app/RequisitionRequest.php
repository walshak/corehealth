<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Requisition;
use App\Product;

class RequisitionRequest extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'requisitions_requests';
    protected $guarded = ['id'];
    protected $fillable = [
        'product_id',
        'requisition_id',
        'price',
        'total_amount',
        'quantity',
        'status',
        'visible',

    ];


    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function requisition()
    {
        return $this->belongsTo('App\Requisition', 'requisition_id', 'id');
    }
}
