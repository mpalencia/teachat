<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';

    protected $fillable = ['parent_id', 'school_id', 'child_id', 'curriculum_id', 'teacher_id', 'section'];

    public function child()
    {
        return $this->belongsTo('Teachat\Models\Children', 'child_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo('Teachat\Models\User', 'teacher_id', 'id')->select('id', 'first_name', 'last_name', 'profile_img');
    }

    public function curriculum()
    {
        return $this->belongsTo('Teachat\Models\Curriculum', 'curriculum_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('Teachat\Models\User', 'parent_id', 'id');
    }
}
