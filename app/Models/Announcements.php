<?php

namespace Teachat\Models;

use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    protected $table = 'announcement';

    protected $fillable = ['user_id', 'school_id', 'announce_to', 'announcement', 'title'];

    protected $hidden = ['password', 'remember_token'];
    /*public function school()
    {
    return $this->hasOne('Teachat\Models\School');
    }*/

    public function user()
    {
        return $this->belongsTo('Teachat\Models\User', 'user_id', 'id');
    }
}
