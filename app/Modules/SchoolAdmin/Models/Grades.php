<?php

namespace App\Modules\SchoolAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    protected $table = 'grades';

    protected $fillable = ['user_id', 'description'];

    public $timestamps = false;
}
