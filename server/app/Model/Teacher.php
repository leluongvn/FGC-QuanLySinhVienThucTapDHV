<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $fillable = ['id_subject', 'id_user', 'msgv', 'fields'];

    public function tbm()
    {
        return $this->belongsTo('App\Model\User', 'id_user', 'id')->where('id_role', 3);
    }

    public function instructor()
    {
        return $this->hasMany(Instructor::class, 'id_teacher', 'id');
    }
}