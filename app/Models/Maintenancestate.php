<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Maintenancestate extends Model
{

    protected $primaryKey = 'StatusId';
    public $timestamps = false;
   
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
		
    ];

   
}
