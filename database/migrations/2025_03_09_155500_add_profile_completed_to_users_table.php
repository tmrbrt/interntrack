<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('student_number')->unique()->nullable();
            $table->string('college')->nullable();
            $table->string('department')->nullable();
            $table->string('profile_picture')->nullable();
            $table->boolean('profile_completed')->default(false);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_completed');
        });

    }
};
