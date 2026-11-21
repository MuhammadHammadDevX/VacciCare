<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentRequest extends Model
{
    use HasFactory;

    protected $table = 'parent_requests';
    protected $primaryKey = 'request_id';

    protected $fillable = [
        'parent_id',
        'child_id',
        'hospital_id',
        'hospital_vaccine_id',
        'request_type',
        'request_date',
        'preferred_time',
        'message',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'request_date' => 'date',
        'reviewed_at' => 'datetime',
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

    public function hospitalVaccine()
    {
        return $this->belongsTo(HospitalVaccine::class, 'hospital_vaccine_id', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'user_id');
    }
}
