<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Internship_Point extends Model
{
    protected $table = 'internship_point';

    protected $fillable = ['id_internship_topic', 'product', 'teacher_comment', 'company_comment', 'teacher_point', 'company_point', 'total_point', 'note'];

    public $timestamps = true;
}
