<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'role_id',
        'school_id',
        'country_id',
        'title',
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
        'password_reset',
        'email_notification',
    ];

    public function state()
    {
        return $this->hasOne('Teachat\Models\StateUs', 'id', 'state_id');
    }

    public function children()
    {
        return $this->hasMany('Teachat\Models\Children', 'id', 'parent_id');
    }

    public function school()
    {
        return $this->hasOne('Teachat\Models\School', 'id', 'school_id');
    }

    public function country()
    {
        return $this->hasOne('Teachat\Models\Country', 'id', 'country_id');
    }
}
