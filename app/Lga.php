<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LGA extends Model
{
    protected $table = 'lgas';

    /**
     * The LGA attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_id',
        'name',
        'visible'];

    /**
     * Get the applicantPersonalDetail record associated with the LGA.
    */
    public function applicantPersonalDetail()
    {
        return $this->hasMany('App\ApplicantPersonalDetail', 'lga_id', 'id');
    }

    public function getState()
    {
       return State::where('id', '=', $this->state_id)->first()->name;
    }

    public function getStateId()
    {
       return State::where('id', '=', $this->state_id)->first()->id;
    }
}
