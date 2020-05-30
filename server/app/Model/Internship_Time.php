<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship_Time extends Model
{
    protected $table = 'internship_time';

    protected $fillable = ['name', 'semester', 'year', 'id_internship_type', 'course', 'start_time', 'end_time', 'start_topic', 'end_topic', 'start_company', 'end_company', 'note'];

    public $timestamps = true;

    public function internship_type()
    {
        return $this->belongsTo(Internship_Type::class, 'id_internship_type', 'id');
    }
}
