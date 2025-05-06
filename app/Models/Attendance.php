<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'time_in',
        'time_out',
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];

   public function student()
{  
    return $this->belongsTo(User::class, 'student_id'); // Reference the users table
    return $this->belongsTo(Student::class, 'student_id', 'id');
    return $this->hasMany(Attendance::class, 'student_id');
}

    // Calculate rendered hours
    public function getRenderedHoursAttribute()
    {
        if ($this->time_in && $this->time_out) {
            return Carbon::parse($this->time_out)->diffInHours(Carbon::parse($this->time_in));
        }
        return 0;
    }
}
