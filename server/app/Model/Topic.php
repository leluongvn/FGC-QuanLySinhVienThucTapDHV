<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = ['id_internship_type', 'name', 'file', 'note', 'status'];

    public $timestamps = true;

    public function internship()
    {
        return $this->hasMany(Internship_Topic::class, 'id_topic', 'id');
    }
}
