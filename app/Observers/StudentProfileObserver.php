<?php

namespace App\Observers;
use App\Events\StudentUpdated;
use App\Models\StudentProfile;

class StudentProfileObserver


{
    public function created(StudentProfile $student)
    {
        event(new StudentUpdated());
    }

    public function updated(StudentProfile $studentProfile)
   {
       event(new StudentUpdated($studentProfile)); // Pass the student profile as argument
   }


    public function deleted(StudentProfile $studentProfile): void
    {
        //
    }

    /**
     * Handle the StudentProfile "restored" event.
     */
    public function restored(StudentProfile $studentProfile): void
    {
        //
    }

    /**
     * Handle the StudentProfile "force deleted" event.
     */
    public function forceDeleted(StudentProfile $studentProfile): void
    {
        //
    }
}
