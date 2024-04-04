<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

	protected $primaryKey = 'DepartmentId';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'DepartmentName',
    ];
    public function assets()
    {
        return $this->hasMany(Asset::class, 'AssetDepartmentId', 'DepartmentId');
    }
}
