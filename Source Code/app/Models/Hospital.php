<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $table = 'hospitals';
    protected $primaryKey = 'hospital_id';

    protected $fillable = [
        'user_id',
        'hospital_name',
        'hospital_type',
        'license_no',
        'email',
        'phone',
        'city',
        'address',
        'latitude',
        'longitude',
        'contact_person',
        'working_hours',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function vaccinators()
    {
        return $this->hasMany(Vaccinator::class, 'hospital_id', 'hospital_id');
    }

    public function hospitalVaccines()
    {
        return $this->hasMany(HospitalVaccine::class, 'hospital_id', 'hospital_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'hospital_id', 'hospital_id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class, 'hospital_id', 'hospital_id');
    }

    public function requests()
    {
        return $this->hasMany(ParentRequest::class, 'hospital_id', 'hospital_id');
    }
}
