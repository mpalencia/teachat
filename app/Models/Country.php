<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';

    protected $fillable = ['name', 'code'];

}
