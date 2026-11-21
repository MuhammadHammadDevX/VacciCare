<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccinator extends Model
{
    use HasFactory;

    protected $table = 'vaccinators';
    protected $primaryKey = 'vaccinator_id';

    protected $fillable = [
        'user_id',
        'hospital_id',
        'name',
        'qualification',
        'phone',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'hospital_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vaccinator_id', 'vaccinator_id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class, 'vaccinator_id', 'vaccinator_id');
    }
}
