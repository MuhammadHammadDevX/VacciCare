<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';
    protected $primaryKey = 'parent_id';

    protected $fillable = [
        'user_id',
        'parent_name',
        'phone',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'parent_id', 'parent_id');
    }

    public function requests()
    {
        return $this->hasMany(ParentRequest::class, 'parent_id', 'parent_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'parent_id', 'parent_id');
    }
}
