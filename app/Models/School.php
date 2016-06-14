<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';

    protected $fillable = ['state_id', 'school_name', 'school_logo', 'upload'];
}
