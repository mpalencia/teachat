<?php namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;

class Pass_encrypt extends Model {

	protected $table = 'encrypted';

	protected $fillable = ['id','password'];

}