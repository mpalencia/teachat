<?php namespace App\Modules\Parent\Models;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{

    protected $table = 'children';

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'birthdate', 'gender', 'child_grade', 'city', 'state_id', 'parent_id', 'approved'];

    public function parent()
    {
        return $this->belongsTo('App\Modules\Registration\Models\Users', 'id', 'parent_id');
    }

    public function state()
    {
        return $this->hasOne('App\Modules\StatesUS\Models\StatesUS', 'id', 'state_id');
    }

    public function grade()
    {
        return $this->hasOne('App\Modules\SchoolAdmin\Models\Grades', 'id', 'grade_id');
    }
}
