<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship_Topic extends Model
{
    protected $table = 'internship_topic';

    protected $fillable = ['id_user', 'id_topic', 'id_internship_time'];

    public function topic(){
        return $this->belongsTo(Topic::class, 'id_topic', 'id');
    }
}