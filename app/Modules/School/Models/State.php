<?php namespace App\Modules\School\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model {

	protected $table = 'state_us';

	protected $fillable = ['state_name','country'];

}
