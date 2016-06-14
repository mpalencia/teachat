<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    protected $table = 'children';

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'birthdate', 'gender', 'child_grade', 'city', 'state_id', 'parent_id', 'school_id', 'grade_id', 'approved', 'section'];

    public function parent()
    {
        return $this->belongsTo('Teachat\Models\User', 'parent_id', 'id');
    }

    public function state()
    {
        return $this->hasOne('Teachat\Models\StateUs', 'id', 'state_id');
    }

    public function grade()
    {
        return $this->hasOne('Teachat\Models\Grades', 'id', 'grade_id');
    }
}
