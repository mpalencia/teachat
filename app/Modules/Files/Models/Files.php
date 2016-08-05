<?php namespace App\Modules\Files\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model {

	protected $table = 'files';

	protected $fillable = ['teacher_id', 'student_id', 'file_name','mimetype','orig_file','ext','file_desc'];

}
