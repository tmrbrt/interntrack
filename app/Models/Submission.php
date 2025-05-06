<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'student_id', 'file_path', 'feedback'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function grade()
{
    return $this->hasOne(Grade::class);
}
    public function submissions()
    {
    return $this->hasMany(Submission::class);
    }
}
