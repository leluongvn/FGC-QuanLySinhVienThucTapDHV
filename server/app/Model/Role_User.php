<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role_User extends Model
{
    protected $table = 'role_user';
    protected $fillable = ['id_user', 'id_role'];

}