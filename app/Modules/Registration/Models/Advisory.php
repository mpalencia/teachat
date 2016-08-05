<?php namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;

class Advisory extends Model {

	protected $table = 'advisory';

	protected $fillable = ['subject_id','section','teacher_id']; 

}
