<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class, 'user_id');
    }
    
    public function coordinatorProfile()
{
    return $this->hasOne(CoordinatorProfile::class, 'user_id');
}

    public function supervisorProfile()
{
    return $this->hasOne(SupervisorProfile::class, 'user_id');
}

    public function assignments()
{
    return $this->hasMany(Assignment::class, 'supervisor_id');
    return $this->hasMany(Assignment::class, 'student_id');
}
public function assignedStudents()
{
    return $this->hasMany(StudentProfile::class, 'supervisor_id', 'id');
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function attendances()
{
    return $this->hasMany(Attendance::class, 'student_id');
}
public function studentAssignments()
{
    return $this->hasMany(Assignment::class, 'student_id');
}
public function grades()
{
    return $this->hasMany(Grade::class, 'student_id');
}

}
