<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicedate extends Model
{
	protected $table = 'servicedates';
	protected $primaryKey = 'ServiceDateId';
	public $timestamps = false;

	protected $fillable = [
        'ServiceDate.*',
    ];


}
