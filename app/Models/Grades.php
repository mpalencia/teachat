<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    protected $table = 'grades';

    protected $fillable = ['user_id', 'school_id', 'description'];
}
