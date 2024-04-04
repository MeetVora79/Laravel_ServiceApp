<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fieldinfo extends Model
{

	protected $primaryKey = 'FieldId';
	public $timestamps = false;


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	public function allocation()
	{
		return $this->belongsTo('App\Models\Allocation', 'AllocationId');
	}
	
	public function ticket()
	{
		return $this->belongsTo('App\Models\Ticket', 'TicketId');
	}
}	
