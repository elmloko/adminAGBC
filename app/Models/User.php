<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }
    public function adminlte_desc()
    {
        // Recupera el nombre del rol del usuario actual
        return $this->getRoleNames()->implode(', ');
    }
    public function adminlte_profile_url()
    {
        return 'profile/username';
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'city',
        'ci',
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
        'password' => 'hashed',
    ];
}
