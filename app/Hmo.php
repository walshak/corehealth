<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Hmo extends Model
{
    use Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'hmos';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'desc',
        'discount',
    ];

    public function patients(){
        return $this->belongsTo('App\Patient','hmo_id','id');
    }

    public function transaction(){
        return $this->hasMany('App\Transaction','hmo_id','id');
    }
}
