<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusticket extends Model
{
    use HasFactory;

	protected $primaryKey = 'StatusId';
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'StatusName',
    ];
    


}
