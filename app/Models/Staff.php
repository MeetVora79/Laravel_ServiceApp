<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

	protected $table = 'staffs';
	protected $primaryKey = 'StaffId';
    /**
     * The attributes that are mass assignable.	
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'StaffName',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role');
    }
}
