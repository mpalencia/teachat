<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'appointment';

    protected $fillable = ['teacher_id', 'parent_id', 'appt_date', 'appt_stime', 'appt_etime', 'file_id', 'title', 'description', 'action'];

    public function parent()
    {
        return $this->belongsTo('Teachat\Models\User', 'parent_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo('Teachat\Models\User', 'teacher', 'id');
    }
}
