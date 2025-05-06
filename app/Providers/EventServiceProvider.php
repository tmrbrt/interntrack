<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\StudentProfile;
use App\Observers\StudentProfileObserver;
use App\Models\Student;
use App\Observers\StudentUpdated;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Register other events here if needed
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        StudentProfile::observe(StudentProfileObserver::class);
    }
}
