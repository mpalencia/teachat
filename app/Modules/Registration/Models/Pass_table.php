<?php namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;

class Pass_table extends Model {

	protected $table = 'encrypted';

	protected $fillable = ['id','password'];

}