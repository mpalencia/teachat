<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    protected $table = 'teacher_profile';

    protected $fillable = ['user_id', 'school_id', 'about', 'address', 'profile_image', 'experience', 'cv_file', 'status'];
}
