<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
	protected $table = 'move';
    protected $primaryKey = 'move_id';
    const CREATED_AT = 'addtime';
    public $timestamps = false;


}
