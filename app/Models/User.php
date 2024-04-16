<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Get the dashboard route name for the user.
     *
     * @return string
     */
    public function getDashboardRouteName()
    {
        switch ($this->role) { // Assuming 'role' is a property that holds the user's role
            case '1':
                return 'admin.dashboard';
            case '2':
                return 'employee.dashboard';
            case '3':
                return 'engineer.dashboard';
            case '4':
                return 'enduser.dashboard';
            default:
                return 'enduser.dashboard'; // Define a default route or handle this case as needed
        }
    }
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

}
