<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class StateUs extends Model
{
    protected $table = 'state_us';

    protected $fillable = ['state_name', 'state_code', 'country_id'];

    public function country()
    {
        return $this->hasOne('Teachat\Models\Country', 'id', 'country_id');
    }

    public function state()
    {
        return $this->hasOne('Teachat\Models\StateUs', 'id', 'id');
    }
}
