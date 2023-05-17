<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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

    protected $with = ['admin', 'supervisor', 'employee', 'department', 'position', 'nationality'];

    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }

    public function admin()
    {
        return $this->belongsTo(UserAdmin::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(UserSupervisor::class);
    }

    public function employee()
    {
        return $this->belongsTo(UserEmployee::class);
    }

    public function department()
    {
        return $this->belongsTo(UserDepartment::class);
    }

    public function position()
    {
        return $this->belongsTo(UserPosition::class);
    }

    public function nationality()
    {
        return $this->belongsTo(UserNationality::class);
    }
}
