<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Specialized extends Model
{
    protected $table = 'specialized';

    protected $fillable = ['name','id_academy', 'note'];

    public $timestamps = true;

    public function academy()
    {
        return $this->belongsTo('App\Academy');
    }

    public function internship_type()
    {
        return $this->hasMany('App\Internship_Type');
    }
}
