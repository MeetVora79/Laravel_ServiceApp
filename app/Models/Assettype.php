<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assettype extends Model
{
    use HasFactory;

	protected $primaryKey = 'AssetTypeId';

    public $timestamps = false;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'AssetTypeName',
    ];


    public function assets()
    {
        return $this->hasMany(Asset::class, 'AssetTypeId', 'AssetTypeId');
    }
}
