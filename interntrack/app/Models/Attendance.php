<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',  // Allow mass assignment for student ID
        'date',
        'time_in',
        'time_out',
    ];

    // Define relationship with User model (assuming students are users)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
