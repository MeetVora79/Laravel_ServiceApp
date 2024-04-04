<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Priorityticket extends Model
{
    use HasFactory;

	protected $primaryKey = 'PriorityId';
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'PriorityName',
    ];


}
