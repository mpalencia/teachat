<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'school_id',
        'role_id',
        'first_name',
        'middle_name',
        'last_name',
        'profile_img',
        'gender',
        'active',
        'verification_code',
        'status',
        'suspend',
        'state_id',
        'birthdate',
        'zip_code',
        'city',
        'contact_cell',
        'contact_home',
        'contact_work',
        'address_one',
        'address_two',
        'approved',
    ];

    public function state()
    {
        return $this->hasOne('Teachat\Models\StateUS', 'id', 'state_id');
    }

    public function children()
    {
        return $this->hasMany('Teachat\Models\Children', 'id', 'parent_id');
    }
}
