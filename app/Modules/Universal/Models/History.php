<?php namespace App\Modules\Universal\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model {

	//
	protected $table = 'history';

	protected $fillable = ['user_id','opponent_id','duration','date','time'];

}
