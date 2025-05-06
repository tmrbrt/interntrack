<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordinatorProfile extends Model
{
    use HasFactory;

    protected $table = 'coordinator_profiles'; // Ensure this matches your actual table name

    protected $fillable = [
        'user_id',
        'name',       // Added based on your previous request
        'department',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
