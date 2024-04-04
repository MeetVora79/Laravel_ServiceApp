<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
	use HasApiTokens, HasFactory, Notifiable, HasRoles;

	protected $primaryKey = 'AllocationId';
	public $timestamps = false;


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */

	protected $fillable = [
		'TicketId',
		'AssignId',
		'ServiceDate',
		'TimeSlot',
		'Instruction',

	];

	public function staff()
	{
		return $this->belongsTo('App\Models\Staff', 'AssignId');
	}
	
	public function ticket()
	{
		return $this->belongsTo('App\Models\Ticket', 'TicketId');
	}
}
