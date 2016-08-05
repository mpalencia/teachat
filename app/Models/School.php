<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';

    protected $fillable = ['state_id', 'school_name', 'school_logo', 'upload', 'country_id', 'active'];

    public function state()
    {
        return $this->hasOne('Teachat\Models\StateUs', 'id', 'state_id');
    }

    public function country()
    {
        return $this->hasOne('Teachat\Models\Country', 'id', 'country_id');
    }
}
