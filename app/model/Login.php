<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'u_id';
    const CREATED_AT = 'create_time';
}
