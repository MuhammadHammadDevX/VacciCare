<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'parent_id',
        'child_id',
        'hospital_id',
        'vaccine_id',
        'vaccinator_id',
        'booking_date',
        'booking_time',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id', 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id', 'child_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'hospital_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id', 'vaccine_id');
    }

    public function vaccinator()
    {
        return $this->belongsTo(Vaccinator::class, 'vaccinator_id', 'vaccinator_id');
    }
}
