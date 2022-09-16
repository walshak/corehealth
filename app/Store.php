<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Product;
use App\StoreStoke;

class Store extends Model
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'stores';

    protected $guarded = ['id'];

    protected $fillable = [
        'store_name',
        'location',
        'visible',
        'created_at',
        'updated_at',
    ];

    // Relationships between store model and the one listed below
    public function product () {

        return $this->belongsTo('App\Product');
    }

    public function transaction () {

        return $this->hasMany('App\Transaction', 'store_id', 'id');
    }

}
