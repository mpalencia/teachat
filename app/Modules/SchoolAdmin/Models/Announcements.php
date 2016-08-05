<?php

namespace App\Modules\SchoolAdmin\Models;

use App\Modules\School\Models\School;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    protected $table = 'announcement';

    protected $fillable = ['user_id', 'school_id', 'announce_to', 'announcement', 'title'];

    public function school()
    {
        return $this->hasOne('App\Modules\School\Models\School');
    }
}
