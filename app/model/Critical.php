<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Critical extends Model
{
	protected $table = 'critical';
    protected $primaryKey = 'critical_id';
    public $timestamps = true;
}
