<?php

namespace App\Modules\StatesUS\Models;

use Illuminate\Database\Eloquent\Model;

class StatesUS extends Model
{
    protected $table = 'state_us';

    protected $fillable = ['state_name', 'state_code', 'country'];
}
