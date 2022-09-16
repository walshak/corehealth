<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NursingNoteType extends Model
{
    public function notes(){
        return $this->hasMany(NursingNote::class,'nursing_note_type_id','id');
    }
}
