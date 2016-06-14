<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectCategory extends Model
{
    protected $table = 'subject_category';

    protected $fillable = ['user_id', 'school_id', 'description'];
}
