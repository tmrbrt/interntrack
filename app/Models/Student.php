<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\OjtConfiguration;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student_profiles';
    protected $fillable = ['name'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
    // Relationship to Submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // Relationship to Assignments
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Calculate Rendered Hours
    public function getRenderedHoursAttribute()
    {
        return $this->attendances->sum(function ($attendance) {
            if ($attendance->time_in && $attendance->time_out) {
                return Carbon::parse($attendance->time_out)->diffInHours(Carbon::parse($attendance->time_in));
            }
            return 0;
        });
    }

    public function department()
{
    return $this->belongsTo(Department::class);
}

public function college()
{
    return $this->belongsTo(College::class);
}
}
