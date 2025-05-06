<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['supervisor_id', 'title', 'description'];

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

}
