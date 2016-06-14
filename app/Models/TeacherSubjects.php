<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjects extends Model
{
    protected $table = 'teacher_subjects';

    protected $fillable = ['user_id', 'school_id', 'subject_id'];

    public function grades()
    {
        return $this->belongsTo('Teachat\Models\Grades', '-', 'id');
    }

    public function subjectCategory()
    {
        return $this->belongsTo('Teachat\Models\SubjectCategory', 'subject_category_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo('Teachat\Models\Curriculum', 'subject_id', 'id');
    }
}
