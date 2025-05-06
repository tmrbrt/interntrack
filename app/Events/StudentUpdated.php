<?php

namespace App\Events;

use App\Models\StudentProfile;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentUpdated
{
    use Dispatchable, SerializesModels;

    public $student;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\StudentProfile $student
     * @return void
     */
    public function __construct(StudentProfile $student)
    {
        $this->student = $student;
    }
}
