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
        return $this->hasOne(UserAdmin::class, 'user_id', 'id');
    }

    public function supervisor()
    {
        return $this->hasOne(UserSupervisor::class, 'user_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne(UserEmployee::class, 'user_id', 'id');
    }

    public function department()
    {
        return $this->hasOne(UserDepartment::class, 'user_id', 'id');
    }

    public function position()
    {
        return $this->hasOne(UserPosition::class, 'user_id', 'id');
    }

    public function nationality()
    {
        return $this->hasOne(UserNationality::class, 'user_id', 'id');
    }

    public function Qr()
    {
        return $this->hasOne(QR::class, 'user_id', 'id');
    }

    public function fileStorage()
    {
        return $this->belongsToMany(FileStorage::class, 'user_file_storages', 'user_id', 'file_storage_id');
    }
}
