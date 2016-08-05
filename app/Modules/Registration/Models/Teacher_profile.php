<?php namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher_profile extends Model
{

    protected $table = 'teacher_profile';

    protected $fillable = ['user_id', 'contact_no', 'school_id'];

}
