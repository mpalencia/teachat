<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;
use Teachat\Models\Grades;
use Teachat\Models\SubjectCategory;

class Curriculum extends Model
{
    protected $table = 'curriculum';

    protected $fillable = ['user_id', 'school_id', 'grade_id', 'subject_category_id', 'subject'];

    public function grades()
    {
        return $this->belongsTo('Teachat\Models\Grades', 'grade_id', 'id');
    }

    public function subjectCategory()
    {
        return $this->belongsTo('Teachat\Models\SubjectCategory', 'subject_category_id', 'id');
    }
}
