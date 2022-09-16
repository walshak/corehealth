<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'is_admin',
        'status_category_id',
        'filename',
        'slug',
        'surname',
        'firstname',
        'othername',
        'email',
        'phone_number',
        'content',
        'designation',
        'customer_id',
        'password',
        'suspended',
        'visible',
        'assignRole',
        'assignPermission',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNameAttribute()
    {
        $optionalOthername = ($this->othername) ? $this->othername : '';
        return ucwords($this->surname . ' ' . $this->firstname . ' ' . $optionalOthername);
    }

    public function statuscategory()
    {
        return $this->belongsTo('App\StatusCategory', 'is_admin', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'visible', 'id');
    }

    public function dailyexpenses()
    {
        return $this->belongsTo('App\DailyExpense');
    }

    public function transactions()
    {
        return $this->belongsTo('App\Transaction', 'staff_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient','user_id','id');
    }

    public function vitalSign()
    {
        return $this->hasMany('App\VitalSign');
    }


    public function medicalReport()
    {
        return $this->hasMany('App\MedicalReport', 'user_id', 'id');
    }

    public function appointment(){
        return $this->hasMany('App\Appointment');
    }

    public function ward_notes(){
        return $this->hasMany('App\WardNote','user_id','id');
    }

    public function nursing_notes(){
        return $this->HasMany(NursingNote::class,'created_by','id');
    }
}
