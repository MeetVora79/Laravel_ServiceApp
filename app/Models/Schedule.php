<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
	use HasApiTokens, HasFactory, Notifiable, HasRoles;

	protected $primaryKey = 'ScheduleId';
	// public $timestamps = false;


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */

	protected $fillable = [
		'AssetId',
		'AssignedId',
		'ServiceDate',
		'Instruction',
	];

	public function staff()
	{
		return $this->belongsTo('App\Models\Staff', 'AssignedId');
	}
	
	public function asset()
	{
		return $this->belongsTo('App\Models\Asset', 'AssetId');
	}

	public function maintenancestatus()
	{
		return $this->belongsTo('App\Models\Maintenancestate', 'MaintenanceStatusId');
	}
}
