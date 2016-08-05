<?php namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;

class Parent_profile extends Model
{

    protected $table = 'parent_profile';

    protected $fillable = ['user_id', 'address', 'contact_cell', 'contact_home', 'contact_work'];

}
