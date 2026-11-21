<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalVaccine extends Model
{
    use HasFactory;

    protected $table = 'hospital_vaccines';
    protected $primaryKey = 'id';

    protected $fillable = [
        'hospital_id',
        'vaccine_name',
        'description',
        'availability',
        'stock_quantity',
        'batch_number',
        'expiry_date',
        'low_stock_threshold',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'expiry_date' => 'date',
    ];

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold && $this->stock_quantity > 0;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expiry_date && !$this->isExpired() && $this->expiry_date->diffInDays(now()) <= $days;
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'hospital_id');
    }
}
