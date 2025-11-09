<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // 👈 penting
    protected $primaryKey = 'id_user'; // 👈 penting, karena relasi ke Toko pakai id_user

    protected $fillable = [
        'name',
        'email',
        'password',
        'nama',
        'kontak',
        'username',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tokos()
    {
        return $this->hasMany(Toko::class, 'id_user', 'id_user');
    }
}
