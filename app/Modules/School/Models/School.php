<?php namespace App\Modules\School\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{

    protected $table = 'school';

    protected $fillable = ['school_name', 'school_logo', 'state_id', 'upload'];

}
