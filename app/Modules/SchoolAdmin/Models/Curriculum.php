<?php

namespace App\Modules\SchoolAdmin\Models;

use App\Modules\SchoolAdmin\Models\Grades;
use App\Modules\SchoolAdmin\Models\SubjectCategory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculum';

    protected $fillable = ['user_id', 'school_id', 'grade_id', 'subject_category_id', 'subject'];

    public function grades()
    {
        return $this->belongsTo('App\Modules\SchoolAdmin\Models\Grades', 'grade_id', 'id');
    }

    public function subjectCategory()
    {
        return $this->belongsTo('App\Modules\SchoolAdmin\Models\SubjectCategory', 'subject_category_id', 'id');
    }
}
