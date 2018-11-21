<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPermissionsTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'tendoanvien', 'ngaysinh', 'gioitinh',
        'quequan', 'dantoc', 'ngayvaodoan', 'noivaodoan', 'chucvu','sodienthoai', 'dangvien',
        'hinhanh', 'chidoan_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
        return $this->hasRole('admin');
    }
    public function isManager() {
        return $this->hasRole('manager');
    }
    public function isStudent() {
        return $this->hasRole('student');
    }
}
