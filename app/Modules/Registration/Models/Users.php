<?php namespace App\Modules\Registration\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    protected $table = 'users';

    protected $fillable = ['email', 'password', 'first_name', 'middle_name', 'last_name', 'active', 'profile_img', 'gender', 'state_id', 'zip_code', 'address_one', 'address_two', 'facebook_id', 'city', 'contact_cell', 'contact_home', 'contact_work', 'role_id', 'school_id', 'verification_code', 'status', 'temp_pass', 'approved'];

    public function state()
    {
        return $this->hasOne('App\Modules\StatesUS\Models\StatesUS', 'id', 'state_id');
    }

    public function children()
    {
        return $this->hasMany('App\Modules\Parent\Models\Children', 'id', 'parent_id');
    }
}
