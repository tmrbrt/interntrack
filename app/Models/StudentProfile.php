<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'address', 'date_of_birth', 'student_number', 'college', 'department', 'profile_picture',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // A student profile belongs to a user
}

public function attendances()
{
    return $this->hasMany(Attendance::class, 'student_id'); // A student has many attendance records
}

public function supervisor()
{
    return $this->belongsTo(User::class, 'supervisor_id');
}
public function student()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

}
