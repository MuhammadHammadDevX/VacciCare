<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Exception;

class Child extends Model
{
    use HasFactory;

    protected $table = 'children';
    protected $primaryKey = 'child_id';

    protected $fillable = [
        'parent_id',
        'child_name',
        'date_of_birth',
        'gender',
        'blood_group',
        'contact',
        'additional_notes',
        'vaccination_status',
    ];

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id', 'parent_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'child_id', 'child_id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class, 'child_id', 'child_id');
    }

    public function requests()
    {
        return $this->hasMany(ParentRequest::class, 'child_id', 'child_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'child_id', 'child_id');
    }

    public function latestCertificate()
    {
        return $this->hasOne(Certificate::class, 'child_id', 'child_id')->latestOfMany('issued_at');
    }

    public function getAgeAttribute(): string
    {
        if (empty($this->date_of_birth)) {
            return 'N/A';
        }

        try {
            $birthDate = new DateTime($this->date_of_birth);
            $today = new DateTime();
            $diff = $birthDate->diff($today);

            if ($diff->y > 0) {
                return $diff->y . ' ' . ($diff->y == 1 ? 'Year' : 'Years');
            }

            if ($diff->m > 0) {
                return $diff->m . ' ' . ($diff->m == 1 ? 'Month' : 'Months');
            }

            return 'Less than 1 Month';
        } catch (Exception $e) {
            return 'N/A';
        }
    }
}
