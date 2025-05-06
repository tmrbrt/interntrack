<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['supervisor_id', 'message'];

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
