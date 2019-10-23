<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    protected $table = 'academy';

    protected $fillable = ['name', 'note'];

    public $timestamps = true;

    public function specialized()
    {
        return $this->hasMany('App\Specialized');
    }
    
}
