<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $table = 'vaccines';
    protected $primaryKey = 'vaccine_id';

    protected $fillable = [
        'vaccine_name',
        'description',
        'manufacturer',
        'recommended_age',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vaccine_id', 'vaccine_id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class, 'vaccine_id', 'vaccine_id');
    }
}
