<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class NextOfKing extends Model
{
   protected $table = 'next_of_kings';
     protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'visible',


    ];
    
    public function user()
	{
	    return $this->belongsTo('App\User');
	} 
}
