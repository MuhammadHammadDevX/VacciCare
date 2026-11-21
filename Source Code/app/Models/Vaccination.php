<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $table = 'vaccinations';
    protected $primaryKey = 'vaccination_id';

    protected $fillable = [
        'child_id',
        'vaccine_id',
        'hospital_id',
        'vaccinator_id',
        'vaccination_date',
        'vaccination_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id', 'child_id');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id', 'vaccine_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'hospital_id');
    }

    public function vaccinator()
    {
        return $this->belongsTo(Vaccinator::class, 'vaccinator_id', 'vaccinator_id');
    }
}
