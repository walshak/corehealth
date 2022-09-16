<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NursingNote extends Model
{
    protected $fillable = [
        'patient_id',
        'dependant_id',
        'created_by',
        'nursing_note_type_id',
        'note',
        'completed',
        'status'
    ];
    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','id');
    }

    public function created_by(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function type(){
        return $this->belongsTo(NursingNoteType::class,'nursing_note_type_id','id');
    }
}

