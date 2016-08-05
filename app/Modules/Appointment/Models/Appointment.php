<?php namespace App\Modules\Appointment\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $table = 'appointment';

    protected $fillable = ['teacher_id', 'parent_id', 'appt_date', 'appt_stime', 'appt_etime', 'file_id', 'title', 'description', 'action'];

}
