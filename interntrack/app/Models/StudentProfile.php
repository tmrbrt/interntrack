<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address', 'date_of_birth', 'student_number', 'college', 'department', 'profile_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
