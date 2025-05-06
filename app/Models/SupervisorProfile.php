<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_name', 'company_address', 'department', 'profile_picture'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
