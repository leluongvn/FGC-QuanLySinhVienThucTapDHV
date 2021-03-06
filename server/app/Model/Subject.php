<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $table = 'subjects';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'status'];

    public function teacher()
    {
        return $this->hasMany(Teacher::class, 'id_subject', 'id');
    }
}
