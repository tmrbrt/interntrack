<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;

    // ✅ Explicitly define the table name
    protected $table = 'coordinator_profiles';

    protected $fillable = ['user_id', 'department'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
