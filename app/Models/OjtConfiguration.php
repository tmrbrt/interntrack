<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OjtConfiguration extends Model
{
    protected $fillable = ['department', 'college', 'required_hours'];

    // Relationships with Department and College (if necessary)
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }
}

