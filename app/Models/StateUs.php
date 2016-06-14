<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class StateUs extends Model
{
    protected $table = 'state_us';

    protected $fillable = ['state_name', 'state_code', 'country'];
}
