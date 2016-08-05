<?php namespace App\Modules\Student\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

	protected $table = 'students';

	protected $fillable = ['child_id','parent_id','subject_id','child_grade','teacher_id','child_section']; 

}
