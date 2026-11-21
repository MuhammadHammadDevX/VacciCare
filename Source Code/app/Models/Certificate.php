<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';
    protected $primaryKey = 'certificate_id';

    protected $fillable = [
        'child_id',
        'certificate_number',
        'verification_token',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id', 'child_id');
    }
}
