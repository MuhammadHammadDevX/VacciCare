<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HospitalUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'hospital_users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'hospital_name',
        'hospital_type',
        'registration_number',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
