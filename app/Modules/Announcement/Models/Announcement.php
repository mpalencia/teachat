<?php namespace App\Modules\Announcement\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model {

	protected $table = 'announcement';

	protected $fillable = ['user_id','announceTo','announcement','school_id','announceTitle'];

}
