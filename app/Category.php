<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = ['id'];
    protected $fillable = [
        'category_name',
        'category_code',
        'category_description',
        'status_id',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
